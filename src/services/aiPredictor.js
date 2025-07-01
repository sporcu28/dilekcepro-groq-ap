import * as tf from '@tensorflow/tfjs-node';

export class AIPredictor {
  constructor() {
    this.model = null;
    this.isInitialized = false;
    this.predictionHistory = new Map();
    this.eventWeights = {
      goal: 0.3,
      corner: 0.15,
      yellow_card: 0.1,
      red_card: 0.05,
      substitution: 0.08,
      offside: 0.12,
      foul: 0.2
    };
    
    this.initializeModel();
  }
  
  async initializeModel() {
    try {
      // Create a simple neural network for prediction
      this.model = tf.sequential({
        layers: [
          tf.layers.dense({ inputShape: [15], units: 64, activation: 'relu' }),
          tf.layers.dropout({ rate: 0.3 }),
          tf.layers.dense({ units: 32, activation: 'relu' }),
          tf.layers.dropout({ rate: 0.2 }),
          tf.layers.dense({ units: 16, activation: 'relu' }),
          tf.layers.dense({ units: 7, activation: 'softmax' }) // 7 event types
        ]
      });
      
      this.model.compile({
        optimizer: tf.train.adam(0.001),
        loss: 'categoricalCrossentropy',
        metrics: ['accuracy']
      });
      
      // Train with synthetic data
      await this.trainWithSyntheticData();
      this.isInitialized = true;
      
      console.log('🤖 AI Prediction model initialized successfully');
    } catch (error) {
      console.error('Error initializing AI model:', error);
      this.isInitialized = false;
    }
  }
  
  async trainWithSyntheticData() {
    // Generate synthetic training data
    const trainingData = this.generateTrainingData(1000);
    const xs = tf.tensor2d(trainingData.inputs);
    const ys = tf.tensor2d(trainingData.outputs);
    
    await this.model.fit(xs, ys, {
      epochs: 50,
      batchSize: 32,
      validationSplit: 0.2,
      verbose: 0
    });
    
    xs.dispose();
    ys.dispose();
  }
  
  generateTrainingData(samples) {
    const inputs = [];
    const outputs = [];
    
    for (let i = 0; i < samples; i++) {
      // Match features: [minute, homeScore, awayScore, possession, shots, corners, fouls, cards, teamStrength, momentum, pressure, fatigue, homeAdvantage, recentForm, weatherCondition]
      const minute = Math.random() * 90;
      const homeScore = Math.floor(Math.random() * 5);
      const awayScore = Math.floor(Math.random() * 5);
      const possession = Math.random() * 100;
      const shots = Math.random() * 20;
      const corners = Math.random() * 15;
      const fouls = Math.random() * 25;
      const cards = Math.random() * 8;
      const teamStrength = Math.random();
      const momentum = Math.random();
      const pressure = Math.random();
      const fatigue = minute / 90; // Fatigue increases with time
      const homeAdvantage = 0.1; // Small home advantage
      const recentForm = Math.random();
      const weather = Math.random();
      
      const features = [
        minute / 90, // Normalize minute
        homeScore / 5, // Normalize scores
        awayScore / 5,
        possession / 100,
        shots / 20,
        corners / 15,
        fouls / 25,
        cards / 8,
        teamStrength,
        momentum,
        pressure,
        fatigue,
        homeAdvantage,
        recentForm,
        weather
      ];
      
      // Generate realistic event probabilities based on features
      const eventProbs = this.calculateEventProbabilities(features);
      
      inputs.push(features);
      outputs.push(eventProbs);
    }
    
    return { inputs, outputs };
  }
  
  calculateEventProbabilities(features) {
    const [minute, homeScore, awayScore, possession, shots, corners, fouls, cards, teamStrength, momentum, pressure, fatigue] = features;
    
    // Base probabilities per minute
    let goalProb = 0.02 + (shots * 0.01) + (momentum * 0.01);
    let cornerProb = 0.05 + (pressure * 0.02);
    let yellowCardProb = 0.03 + (fouls * 0.01);
    let redCardProb = 0.002 + (cards * 0.001);
    let substitutionProb = minute > 0.6 ? 0.01 + (fatigue * 0.02) : 0.001;
    let offsideProb = 0.04 + (pressure * 0.01);
    let foulProb = 0.06 + (pressure * 0.02) + (fatigue * 0.01);
    
    // Adjust based on match state
    if (Math.abs(homeScore - awayScore) > 2) {
      goalProb *= 0.7; // Less likely when one team is dominating
    }
    
    const total = goalProb + cornerProb + yellowCardProb + redCardProb + substitutionProb + offsideProb + foulProb;
    
    return [
      goalProb / total,
      cornerProb / total,
      yellowCardProb / total,
      redCardProb / total,
      substitutionProb / total,
      offsideProb / total,
      foulProb / total
    ];
  }
  
  async getPredictions(matchData) {
    if (!this.isInitialized) {
      return this.getFallbackPredictions(matchData);
    }
    
    try {
      const features = this.extractFeatures(matchData);
      const prediction = this.model.predict(tf.tensor2d([features]));
      const probabilities = await prediction.data();
      prediction.dispose();
      
      const eventTypes = ['goal', 'corner', 'yellow_card', 'red_card', 'substitution', 'offside', 'foul'];
      const predictions = {};
      
      eventTypes.forEach((eventType, index) => {
        predictions[eventType] = {
          probability: probabilities[index],
          confidence: this.calculateConfidence(probabilities[index]),
          timeWindow: this.estimateTimeWindow(eventType, matchData),
          factors: this.getInfluencingFactors(eventType, matchData)
        };
      });
      
      // Store prediction for learning
      this.predictionHistory.set(matchData.id, {
        timestamp: Date.now(),
        predictions,
        matchState: features
      });
      
      return predictions;
    } catch (error) {
      console.error('Error in AI prediction:', error);
      return this.getFallbackPredictions(matchData);
    }
  }
  
  async predictEvent(matchData, eventType) {
    const predictions = await this.getPredictions(matchData);
    const eventPrediction = predictions[eventType];
    
    if (!eventPrediction) {
      return { error: 'Unknown event type' };
    }
    
    return {
      eventType,
      probability: eventPrediction.probability,
      confidence: eventPrediction.confidence,
      expectedTime: eventPrediction.timeWindow,
      factors: eventPrediction.factors,
      recommendation: this.generateRecommendation(eventType, eventPrediction),
      accuracy: this.getHistoricalAccuracy(eventType)
    };
  }
  
  async predictNextEvent(matchData, recentEvent) {
    // Analyze how recent event affects next event probabilities
    const basePredictions = await this.getPredictions(matchData);
    const adjustedPredictions = this.adjustPredictionsAfterEvent(basePredictions, recentEvent, matchData);
    
    // Find most likely next event
    const sortedEvents = Object.entries(adjustedPredictions)
      .sort(([,a], [,b]) => b.probability - a.probability);
    
    const nextEvent = sortedEvents[0];
    
    return {
      nextEventType: nextEvent[0],
      probability: nextEvent[1].probability,
      confidence: nextEvent[1].confidence,
      timeWindow: nextEvent[1].timeWindow,
      reasoning: this.explainPrediction(nextEvent[0], recentEvent, matchData)
    };
  }
  
  extractFeatures(matchData) {
    const minute = (matchData.minute || 0) / 90;
    const homeScore = (matchData.score?.fullTime?.home || 0) / 5;
    const awayScore = (matchData.score?.fullTime?.away || 0) / 5;
    const stats = matchData.statistics || {};
    
    return [
      minute,
      homeScore,
      awayScore,
      (stats.possession?.home || 50) / 100,
      (stats.shots?.home || 5) / 20,
      (stats.corners?.home || 3) / 15,
      (stats.fouls?.home || 8) / 25,
      (matchData.events?.filter(e => e.type.includes('card')).length || 0) / 8,
      0.8, // Team strength (would be calculated from historical data)
      this.calculateMomentum(matchData),
      this.calculatePressure(matchData),
      minute, // Fatigue factor
      0.1, // Home advantage
      0.7, // Recent form
      0.5  // Weather condition
    ];
  }
  
  calculateMomentum(matchData) {
    const recentEvents = (matchData.events || []).slice(-3);
    let momentum = 0.5; // Neutral
    
    recentEvents.forEach(event => {
      if (event.type === 'goal') {
        momentum += event.team === 'home' ? 0.2 : -0.2;
      } else if (event.type === 'red_card') {
        momentum += event.team === 'home' ? -0.3 : 0.3;
      }
    });
    
    return Math.max(0, Math.min(1, momentum));
  }
  
  calculatePressure(matchData) {
    const minute = matchData.minute || 0;
    const homeScore = matchData.score?.fullTime?.home || 0;
    const awayScore = matchData.score?.fullTime?.away || 0;
    const scoreDiff = Math.abs(homeScore - awayScore);
    
    let pressure = 0.5;
    
    // Time pressure
    if (minute > 70) pressure += 0.2;
    if (minute > 85) pressure += 0.2;
    
    // Score pressure
    if (scoreDiff === 1) pressure += 0.15;
    if (scoreDiff === 0) pressure += 0.1;
    
    return Math.max(0, Math.min(1, pressure));
  }
  
  calculateConfidence(probability) {
    // Higher confidence for moderate probabilities, lower for extremes
    if (probability < 0.1 || probability > 0.9) return 0.6;
    if (probability >= 0.3 && probability <= 0.7) return 0.9;
    return 0.8;
  }
  
  estimateTimeWindow(eventType, matchData) {
    const minute = matchData.minute || 0;
    const remaining = 90 - minute;
    
    const baseWindows = {
      goal: Math.min(15, remaining),
      corner: Math.min(8, remaining),
      yellow_card: Math.min(10, remaining),
      red_card: Math.min(20, remaining),
      substitution: Math.min(12, remaining),
      offside: Math.min(5, remaining),
      foul: Math.min(3, remaining)
    };
    
    return `${Math.max(1, Math.floor(baseWindows[eventType] * 0.5))}-${baseWindows[eventType]} dakika`;
  }
  
  getInfluencingFactors(eventType, matchData) {
    const factors = [];
    const minute = matchData.minute || 0;
    const stats = matchData.statistics || {};
    
    switch (eventType) {
      case 'goal':
        if ((stats.shots?.home || 0) > 8) factors.push('Yüksek şut sayısı');
        if (minute > 70) factors.push('Maç sonu baskısı');
        if ((stats.possession?.home || 50) > 60) factors.push('Top hakimiyeti avantajı');
        break;
      case 'corner':
        if ((stats.possession?.home || 50) > 55) factors.push('Ofansif oyun');
        if (minute > 80) factors.push('Son dakika baskısı');
        break;
      case 'yellow_card':
        if ((stats.fouls?.home || 0) > 10) factors.push('Yüksek faul sayısı');
        if (minute > 60) factors.push('Artan gerginlik');
        break;
    }
    
    return factors;
  }
  
  generateRecommendation(eventType, prediction) {
    if (prediction.probability > 0.7) {
      return `Çok yüksek ihtimal - ${eventType} bekleniyor`;
    } else if (prediction.probability > 0.5) {
      return `Yüksek ihtimal - ${eventType} olası`;
    } else if (prediction.probability > 0.3) {
      return `Orta ihtimal - ${eventType} mümkün`;
    } else {
      return `Düşük ihtimal - ${eventType} beklenmiyor`;
    }
  }
  
  getHistoricalAccuracy(eventType) {
    // In a real system, this would be calculated from historical data
    const baseAccuracies = {
      goal: 0.78,
      corner: 0.85,
      yellow_card: 0.72,
      red_card: 0.65,
      substitution: 0.88,
      offside: 0.70,
      foul: 0.82
    };
    
    return baseAccuracies[eventType] || 0.70;
  }
  
  adjustPredictionsAfterEvent(predictions, recentEvent, matchData) {
    const adjusted = { ...predictions };
    
    switch (recentEvent.type) {
      case 'goal':
        // After a goal, corner and offside probabilities might increase
        adjusted.corner.probability *= 1.2;
        adjusted.offside.probability *= 1.3;
        adjusted.goal.probability *= 0.8; // Goals less likely immediately after
        break;
      case 'red_card':
        // After red card, fouls might decrease, goals might increase for the other team
        adjusted.foul.probability *= 0.7;
        adjusted.goal.probability *= 1.4;
        break;
      case 'yellow_card':
        // After yellow card, more cards might follow
        adjusted.yellow_card.probability *= 1.2;
        adjusted.red_card.probability *= 1.5;
        break;
    }
    
    return adjusted;
  }
  
  explainPrediction(eventType, recentEvent, matchData) {
    const minute = matchData.minute || 0;
    const reasons = [];
    
    if (recentEvent?.type === 'goal') {
      reasons.push('Son gol sonrası oyun temposu arttı');
    }
    
    if (minute > 75) {
      reasons.push('Maçın son bölümünde gerginlik artıyor');
    }
    
    if (eventType === 'goal' && minute > 85) {
      reasons.push('Son dakikalarda gol ihtimali yükseliyor');
    }
    
    return reasons.join(', ') || 'Maç dinamiklerine göre hesaplandı';
  }
  
  getFallbackPredictions(matchData) {
    // Simple rule-based predictions when AI model is not available
    const minute = matchData.minute || 0;
    const normalizedMinute = minute / 90;
    
    return {
      goal: {
        probability: 0.02 + (normalizedMinute * 0.01),
        confidence: 0.7,
        timeWindow: '5-15 dakika',
        factors: ['Maç analizi']
      },
      corner: {
        probability: 0.05 + (normalizedMinute * 0.02),
        confidence: 0.8,
        timeWindow: '2-8 dakika',
        factors: ['Ofansif oyun']
      },
      yellow_card: {
        probability: 0.03 + (normalizedMinute * 0.02),
        confidence: 0.7,
        timeWindow: '3-10 dakika',
        factors: ['Oyun sertliği']
      },
      red_card: {
        probability: 0.005,
        confidence: 0.6,
        timeWindow: '10-30 dakika',
        factors: ['Nadir olay']
      },
      substitution: {
        probability: minute > 60 ? 0.15 : 0.02,
        confidence: 0.8,
        timeWindow: '5-15 dakika',
        factors: minute > 60 ? ['Oyuncu değişikliği zamanı'] : ['Erken değişiklik']
      },
      offside: {
        probability: 0.08,
        confidence: 0.8,
        timeWindow: '1-5 dakika',
        factors: ['Ofansif oyun']
      },
      foul: {
        probability: 0.1,
        confidence: 0.9,
        timeWindow: '1-3 dakika',
        factors: ['Oyun içi kontakt']
      }
    };
  }
}