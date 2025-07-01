export class MatchAnalyzer {
  constructor() {
    this.analysisHistory = new Map();
    this.patterns = this.initializePatterns();
  }
  
  initializePatterns() {
    return {
      goalPatterns: {
        earlyGoal: { minute: 15, impact: 0.3 },
        lateGoal: { minute: 75, impact: 0.4 },
        equalizer: { scoreDiff: 0, impact: 0.5 }
      },
      momentumShifts: {
        goal: 0.4,
        redCard: 0.6,
        substitution: 0.2,
        yellowCard: 0.1
      },
      criticalPeriods: [
        { start: 0, end: 15, name: 'Erken dakikalar', intensity: 0.7 },
        { start: 15, end: 30, name: 'İlk yarı orta', intensity: 0.5 },
        { start: 30, end: 45, name: 'İlk yarı sonu', intensity: 0.8 },
        { start: 45, end: 60, name: 'İkinci yarı başı', intensity: 0.6 },
        { start: 60, end: 75, name: 'Kritik dakikalar', intensity: 0.7 },
        { start: 75, end: 90, name: 'Son dakikalar', intensity: 0.9 }
      ]
    };
  }
  
  async analyzeMatch(matchData) {
    try {
      const analysis = {
        matchId: matchData.id,
        timestamp: Date.now(),
        minute: matchData.minute || 0,
        momentum: this.calculateMomentum(matchData),
        pressure: this.calculatePressure(matchData),
        criticalFactors: this.identifyCriticalFactors(matchData),
        predictions: this.generateShortTermPredictions(matchData),
        insights: this.generateInsights(matchData),
        riskFactors: this.identifyRiskFactors(matchData),
        opportunities: this.identifyOpportunities(matchData),
        gameState: this.analyzeGameState(matchData),
        keyMetrics: this.calculateKeyMetrics(matchData)
      };
      
      // Store analysis for historical tracking
      this.analysisHistory.set(matchData.id, analysis);
      
      return analysis;
    } catch (error) {
      console.error('Error in match analysis:', error);
      return this.getFallbackAnalysis(matchData);
    }
  }
  
  calculateMomentum(matchData) {
    const events = matchData.events || [];
    const recentEvents = events.slice(-5); // Last 5 events
    const minute = matchData.minute || 0;
    
    let homeMomentum = 0.5;
    let awayMomentum = 0.5;
    
    recentEvents.forEach((event, index) => {
      const weight = (index + 1) / recentEvents.length; // More recent events have higher weight
      
      switch (event.type) {
        case 'goal':
          if (event.team === 'home') {
            homeMomentum += 0.3 * weight;
            awayMomentum -= 0.2 * weight;
          } else {
            awayMomentum += 0.3 * weight;
            homeMomentum -= 0.2 * weight;
          }
          break;
        case 'red_card':
          if (event.team === 'home') {
            homeMomentum -= 0.4 * weight;
            awayMomentum += 0.3 * weight;
          } else {
            awayMomentum -= 0.4 * weight;
            homeMomentum += 0.3 * weight;
          }
          break;
        case 'yellow_card':
          if (event.team === 'home') {
            homeMomentum -= 0.1 * weight;
          } else {
            awayMomentum -= 0.1 * weight;
          }
          break;
      }
    });
    
    // Time-based momentum adjustments
    if (minute > 70) {
      const timeBonus = (minute - 70) / 20 * 0.1;
      homeMomentum += timeBonus;
      awayMomentum += timeBonus;
    }
    
    return {
      home: Math.max(0, Math.min(1, homeMomentum)),
      away: Math.max(0, Math.min(1, awayMomentum)),
      overall: Math.abs(homeMomentum - awayMomentum),
      direction: homeMomentum > awayMomentum ? 'home' : 'away'
    };
  }
  
  calculatePressure(matchData) {
    const minute = matchData.minute || 0;
    const homeScore = matchData.score?.fullTime?.home || 0;
    const awayScore = matchData.score?.fullTime?.away || 0;
    const scoreDiff = homeScore - awayScore;
    const stats = matchData.statistics || {};
    
    let pressure = {
      home: 0.5,
      away: 0.5,
      overall: 0.5
    };
    
    // Time-based pressure
    if (minute > 60) pressure.overall += 0.2;
    if (minute > 75) pressure.overall += 0.3;
    if (minute > 85) pressure.overall += 0.4;
    
    // Score-based pressure
    if (scoreDiff > 0) {
      pressure.away += Math.min(0.4, scoreDiff * 0.2);
    } else if (scoreDiff < 0) {
      pressure.home += Math.min(0.4, Math.abs(scoreDiff) * 0.2);
    } else {
      pressure.overall += 0.2; // Equal score increases overall pressure
    }
    
    // Statistics-based pressure
    const homePossession = stats.possession?.home || 50;
    if (homePossession > 60) {
      pressure.home += 0.1;
    } else if (homePossession < 40) {
      pressure.away += 0.1;
    }
    
    // Normalize values
    pressure.home = Math.max(0, Math.min(1, pressure.home));
    pressure.away = Math.max(0, Math.min(1, pressure.away));
    pressure.overall = Math.max(0, Math.min(1, pressure.overall));
    
    return pressure;
  }
  
  identifyCriticalFactors(matchData) {
    const factors = [];
    const minute = matchData.minute || 0;
    const homeScore = matchData.score?.fullTime?.home || 0;
    const awayScore = matchData.score?.fullTime?.away || 0;
    const events = matchData.events || [];
    const stats = matchData.statistics || {};
    
    // Time-based factors
    if (minute > 80) {
      factors.push({
        type: 'time',
        description: 'Maçın son dakikaları - yüksek gerginlik',
        impact: 'high',
        affects: ['goal', 'card', 'substitution']
      });
    }
    
    // Score-based factors
    if (homeScore === awayScore) {
      factors.push({
        type: 'score',
        description: 'Eşit skor - her iki takım da gol arıyor',
        impact: 'medium',
        affects: ['goal', 'corner', 'offside']
      });
    }
    
    // Red card effects
    const redCards = events.filter(e => e.type === 'red_card');
    if (redCards.length > 0) {
      factors.push({
        type: 'cards',
        description: 'Kırmızı kart etkisi - oyun dengesi değişti',
        impact: 'high',
        affects: ['goal', 'foul', 'substitution']
      });
    }
    
    // High possession imbalance
    const possessionDiff = Math.abs((stats.possession?.home || 50) - 50);
    if (possessionDiff > 20) {
      factors.push({
        type: 'possession',
        description: 'Yüksek top hakimiyeti farkı',
        impact: 'medium',
        affects: ['corner', 'goal', 'offside']
      });
    }
    
    // High foul count
    const totalFouls = (stats.fouls?.home || 0) + (stats.fouls?.away || 0);
    if (totalFouls > 20) {
      factors.push({
        type: 'fouls',
        description: 'Yüksek faul sayısı - sert oyun',
        impact: 'medium',
        affects: ['yellow_card', 'red_card', 'foul']
      });
    }
    
    return factors;
  }
  
  generateShortTermPredictions(matchData) {
    const minute = matchData.minute || 0;
    const predictions = {};
    
    // Next 5 minutes predictions
    predictions.next5min = {
      goal: this.calculateShortTermProbability('goal', matchData, 5),
      corner: this.calculateShortTermProbability('corner', matchData, 5),
      card: this.calculateShortTermProbability('yellow_card', matchData, 5),
      substitution: this.calculateShortTermProbability('substitution', matchData, 5)
    };
    
    // Next 10 minutes predictions
    predictions.next10min = {
      goal: this.calculateShortTermProbability('goal', matchData, 10),
      corner: this.calculateShortTermProbability('corner', matchData, 10),
      card: this.calculateShortTermProbability('yellow_card', matchData, 10),
      substitution: this.calculateShortTermProbability('substitution', matchData, 10)
    };
    
    // Until half-time/full-time
    const remaining = minute < 45 ? 45 - minute : 90 - minute;
    if (remaining > 0) {
      predictions.untilBreak = {
        goal: this.calculateShortTermProbability('goal', matchData, remaining),
        corner: this.calculateShortTermProbability('corner', matchData, remaining),
        card: this.calculateShortTermProbability('yellow_card', matchData, remaining)
      };
    }
    
    return predictions;
  }
  
  calculateShortTermProbability(eventType, matchData, timeWindow) {
    const minute = matchData.minute || 0;
    const baseRates = {
      goal: 0.03,
      corner: 0.1,
      yellow_card: 0.05,
      substitution: minute > 60 ? 0.08 : 0.02
    };
    
    let probability = baseRates[eventType] * timeWindow;
    
    // Adjust based on match state
    const momentum = this.calculateMomentum(matchData);
    const pressure = this.calculatePressure(matchData);
    
    if (eventType === 'goal') {
      probability *= (1 + pressure.overall * 0.5);
      probability *= (1 + momentum.overall * 0.3);
    }
    
    if (eventType === 'corner') {
      probability *= (1 + pressure.overall * 0.4);
    }
    
    if (eventType === 'yellow_card') {
      probability *= (1 + pressure.overall * 0.6);
    }
    
    return Math.min(1, probability);
  }
  
  generateInsights(matchData) {
    const insights = [];
    const minute = matchData.minute || 0;
    const homeScore = matchData.score?.fullTime?.home || 0;
    const awayScore = matchData.score?.fullTime?.away || 0;
    const events = matchData.events || [];
    const stats = matchData.statistics || {};
    const momentum = this.calculateMomentum(matchData);
    
    // Momentum insights
    if (momentum.overall > 0.7) {
      insights.push({
        type: 'momentum',
        priority: 'high',
        message: `${momentum.direction === 'home' ? matchData.homeTeam?.name || 'Ev sahibi' : matchData.awayTeam?.name || 'Misafir'} takımında güçlü momentum var`,
        prediction: 'Yakın zamanda gol olasılığı yüksek'
      });
    }
    
    // Score pattern insights
    if (homeScore === awayScore && minute > 70) {
      insights.push({
        type: 'score',
        priority: 'high',
        message: 'Eşit skor ve son dakikalar - kritik an',
        prediction: 'Her an gol gelebilir, kartlar artabilir'
      });
    }
    
    // Statistical insights
    const possessionDiff = Math.abs((stats.possession?.home || 50) - (stats.possession?.away || 50));
    if (possessionDiff > 20) {
      const dominatingTeam = (stats.possession?.home || 50) > 50 ? 'home' : 'away';
      insights.push({
        type: 'possession',
        priority: 'medium',
        message: 'Belirgin top hakimiyeti farkı',
        prediction: 'Hakim takımda korner ve gol şansı yüksek'
      });
    }
    
    // Event pattern insights
    const recentGoals = events.filter(e => e.type === 'goal' && e.minute > minute - 10).length;
    if (recentGoals >= 2) {
      insights.push({
        type: 'goals',
        priority: 'high',
        message: 'Son 10 dakikada çoklu gol',
        prediction: 'Açık oyun devam edebilir, daha fazla gol olası'
      });
    }
    
    // Time-based insights
    if (minute >= 75 && minute <= 85) {
      insights.push({
        type: 'time',
        priority: 'high',
        message: 'Kritik zaman dilimi (75-85. dakika)',
        prediction: 'Oyuncu değişiklikleri ve taktik hamleleri bekleniyor'
      });
    }
    
    return insights;
  }
  
  identifyRiskFactors(matchData) {
    const risks = [];
    const minute = matchData.minute || 0;
    const events = matchData.events || [];
    const stats = matchData.statistics || {};
    
    // High foul risk
    const totalFouls = (stats.fouls?.home || 0) + (stats.fouls?.away || 0);
    if (totalFouls > 15) {
      risks.push({
        type: 'disciplinary',
        level: 'medium',
        description: 'Yüksek faul sayısı',
        consequence: 'Kart riski artıyor'
      });
    }
    
    // Yellow card accumulation
    const yellowCards = events.filter(e => e.type === 'yellow_card').length;
    if (yellowCards >= 3) {
      risks.push({
        type: 'disciplinary',
        level: 'high',
        description: 'Çoklu sarı kart',
        consequence: 'Kırmızı kart riski yüksek'
      });
    }
    
    // Late game fatigue
    if (minute > 80) {
      risks.push({
        type: 'physical',
        level: 'medium',
        description: 'Son dakika yorgunluğu',
        consequence: 'Hata ve sakatlık riski artıyor'
      });
    }
    
    return risks;
  }
  
  identifyOpportunities(matchData) {
    const opportunities = [];
    const minute = matchData.minute || 0;
    const homeScore = matchData.score?.fullTime?.home || 0;
    const awayScore = matchData.score?.fullTime?.away || 0;
    const stats = matchData.statistics || {};
    const momentum = this.calculateMomentum(matchData);
    
    // High momentum opportunity
    if (momentum.overall > 0.6) {
      opportunities.push({
        type: 'momentum',
        probability: 'high',
        description: 'Güçlü momentum avantajı',
        window: '5-10 dakika',
        outcome: 'Gol şansı yüksek'
      });
    }
    
    // Set piece opportunities
    const recentCorners = (stats.corners?.home || 0) + (stats.corners?.away || 0);
    if (recentCorners > 8) {
      opportunities.push({
        type: 'setpiece',
        probability: 'medium',
        description: 'Yüksek korner sayısı',
        window: 'Devam eden',
        outcome: 'Sabit toptan gol olasılığı'
      });
    }
    
    // Late game scenarios
    if (minute > 75) {
      if (homeScore === awayScore) {
        opportunities.push({
          type: 'tactical',
          probability: 'high',
          description: 'Son dakika eşit skor',
          window: '10-15 dakika',
          outcome: 'Kazanan gol için baskı artacak'
        });
      }
    }
    
    return opportunities;
  }
  
  analyzeGameState(matchData) {
    const minute = matchData.minute || 0;
    const homeScore = matchData.score?.fullTime?.home || 0;
    const awayScore = matchData.score?.fullTime?.away || 0;
    const events = matchData.events || [];
    
    const gameState = {
      phase: this.determineGamePhase(minute),
      intensity: this.calculateIntensity(matchData),
      balance: this.calculateBalance(matchData),
      tempo: this.calculateTempo(matchData),
      control: this.determineControl(matchData)
    };
    
    return gameState;
  }
  
  determineGamePhase(minute) {
    if (minute <= 15) return 'Erken dakikalar';
    if (minute <= 30) return 'İlk yarı gelişim';
    if (minute <= 45) return 'İlk yarı bitiş';
    if (minute <= 60) return 'İkinci yarı başlangıç';
    if (minute <= 75) return 'Oyunun gelişim aşaması';
    if (minute <= 85) return 'Kritik dakikalar';
    return 'Son dakikalar';
  }
  
  calculateIntensity(matchData) {
    const minute = matchData.minute || 0;
    const events = matchData.events || [];
    const stats = matchData.statistics || {};
    
    let intensity = 0.5;
    
    // Event-based intensity
    const recentEvents = events.filter(e => e.minute > minute - 10).length;
    intensity += recentEvents * 0.05;
    
    // Time-based intensity
    if (minute > 70) intensity += 0.2;
    if (minute > 85) intensity += 0.3;
    
    // Foul-based intensity
    const totalFouls = (stats.fouls?.home || 0) + (stats.fouls?.away || 0);
    intensity += Math.min(0.3, totalFouls * 0.01);
    
    return Math.min(1, intensity);
  }
  
  calculateBalance(matchData) {
    const stats = matchData.statistics || {};
    const homeShots = stats.shots?.home || 0;
    const awayShots = stats.shots?.away || 0;
    const homePossession = stats.possession?.home || 50;
    
    const shotBalance = homeShots / Math.max(1, homeShots + awayShots);
    const possessionBalance = homePossession / 100;
    
    const overallBalance = (shotBalance + possessionBalance) / 2;
    
    if (overallBalance > 0.6) return 'Ev sahibi avantajlı';
    if (overallBalance < 0.4) return 'Misafir avantajlı';
    return 'Dengeli oyun';
  }
  
  calculateTempo(matchData) {
    const events = matchData.events || [];
    const minute = matchData.minute || 1;
    const eventRate = events.length / minute;
    
    if (eventRate > 0.5) return 'Yüksek tempo';
    if (eventRate > 0.3) return 'Orta tempo';
    return 'Düşük tempo';
  }
  
  determineControl(matchData) {
    const stats = matchData.statistics || {};
    const homePossession = stats.possession?.home || 50;
    const homeShots = stats.shots?.home || 0;
    const awayShots = stats.shots?.away || 0;
    
    const possessionControl = homePossession > 55 ? 'home' : homePossession < 45 ? 'away' : 'equal';
    const shotControl = homeShots > awayShots * 1.5 ? 'home' : awayShots > homeShots * 1.5 ? 'away' : 'equal';
    
    if (possessionControl === shotControl) {
      return possessionControl === 'home' ? 'Ev sahibi kontrol' : 
             possessionControl === 'away' ? 'Misafir kontrol' : 'Dengeli kontrol';
    }
    
    return 'Karma kontrol';
  }
  
  calculateKeyMetrics(matchData) {
    const minute = matchData.minute || 0;
    const events = matchData.events || [];
    const stats = matchData.statistics || {};
    
    return {
      gameIntensity: this.calculateIntensity(matchData),
      eventFrequency: events.length / Math.max(1, minute),
      disciplinaryIndex: events.filter(e => e.type.includes('card')).length,
      attackingIndex: ((stats.shots?.home || 0) + (stats.shots?.away || 0)) / Math.max(1, minute / 10),
      defensiveIndex: ((stats.fouls?.home || 0) + (stats.fouls?.away || 0)) / Math.max(1, minute / 10),
      pressureIndex: this.calculatePressure(matchData).overall,
      momentumIndex: this.calculateMomentum(matchData).overall
    };
  }
  
  getFallbackAnalysis(matchData) {
    return {
      matchId: matchData.id,
      timestamp: Date.now(),
      minute: matchData.minute || 0,
      momentum: { home: 0.5, away: 0.5, overall: 0.3, direction: 'neutral' },
      pressure: { home: 0.5, away: 0.5, overall: 0.4 },
      criticalFactors: [],
      predictions: {
        next5min: { goal: 0.15, corner: 0.25, card: 0.1, substitution: 0.05 },
        next10min: { goal: 0.28, corner: 0.45, card: 0.18, substitution: 0.12 }
      },
      insights: [
        {
          type: 'general',
          priority: 'medium',
          message: 'Standart maç analizi',
          prediction: 'Normal oyun akışı bekleniyor'
        }
      ],
      riskFactors: [],
      opportunities: [],
      gameState: {
        phase: 'Oyun devam ediyor',
        intensity: 0.5,
        balance: 'Dengeli oyun',
        tempo: 'Orta tempo',
        control: 'Dengeli kontrol'
      },
      keyMetrics: {
        gameIntensity: 0.5,
        eventFrequency: 0.3,
        disciplinaryIndex: 0,
        attackingIndex: 0.5,
        defensiveIndex: 0.5,
        pressureIndex: 0.4,
        momentumIndex: 0.3
      }
    };
  }
}