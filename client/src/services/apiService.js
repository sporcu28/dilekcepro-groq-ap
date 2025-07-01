import axios from 'axios';

const API_BASE_URL = process.env.REACT_APP_API_URL || 'http://localhost:3000';

class ApiServiceClass {
  constructor() {
    this.api = axios.create({
      baseURL: `${API_BASE_URL}/api`,
      timeout: 10000,
      headers: {
        'Content-Type': 'application/json'
      }
    });

    // Request interceptor
    this.api.interceptors.request.use(
      (config) => {
        console.log(`🌐 API Request: ${config.method?.toUpperCase()} ${config.url}`);
        return config;
      },
      (error) => {
        console.error('Request error:', error);
        return Promise.reject(error);
      }
    );

    // Response interceptor
    this.api.interceptors.response.use(
      (response) => {
        console.log(`✅ API Response: ${response.config.url} - ${response.status}`);
        return response;
      },
      (error) => {
        console.error('Response error:', error);
        
        if (error.response) {
          // Server responded with error status
          console.error('Server error:', error.response.status, error.response.data);
        } else if (error.request) {
          // Request was made but no response received
          console.error('Network error:', error.request);
        } else {
          // Something else happened
          console.error('Request setup error:', error.message);
        }
        
        return Promise.reject(error);
      }
    );
  }

  // Get live matches
  async getLiveMatches() {
    try {
      const response = await this.api.get('/live-matches');
      return response.data;
    } catch (error) {
      console.error('Error fetching live matches:', error);
      // Return demo data if API fails
      return this.getDemoMatches();
    }
  }

  // Get match details with predictions
  async getMatchDetails(matchId) {
    try {
      const response = await this.api.get(`/match/${matchId}`);
      return response.data;
    } catch (error) {
      console.error('Error fetching match details:', error);
      // Return demo data if API fails
      return this.getDemoMatchDetails(matchId);
    }
  }

  // Get specific event prediction
  async getPrediction(matchId, eventType) {
    try {
      const response = await this.api.post('/predict', {
        matchId,
        eventType
      });
      return response.data;
    } catch (error) {
      console.error('Error getting prediction:', error);
      throw error;
    }
  }

  // Demo data fallbacks
  getDemoMatches() {
    return [
      {
        id: 'demo_1',
        homeTeam: 'Galatasaray',
        awayTeam: 'Fenerbahçe',
        score: { fullTime: { home: 2, away: 1 }, halfTime: { home: 1, away: 0 } },
        minute: 67,
        status: 'IN_PLAY',
        competition: 'Süper Lig',
        startTime: new Date().toISOString(),
        events: [
          { type: 'goal', minute: 23, team: 'home', player: 'Icardi', description: 'Gol - Icardi' },
          { type: 'goal', minute: 45, team: 'away', player: 'Dzeko', description: 'Gol - Dzeko' },
          { type: 'goal', minute: 56, team: 'home', player: 'Mertens', description: 'Gol - Mertens' },
          { type: 'yellow_card', minute: 61, team: 'away', player: 'Ferdi', description: 'Sarı kart - Ferdi' }
        ]
      },
      {
        id: 'demo_2',
        homeTeam: 'Real Madrid',
        awayTeam: 'Barcelona',
        score: { fullTime: { home: 1, away: 1 }, halfTime: { home: 0, away: 1 } },
        minute: 78,
        status: 'IN_PLAY',
        competition: 'La Liga',
        startTime: new Date().toISOString(),
        events: [
          { type: 'goal', minute: 32, team: 'away', player: 'Lewandowski', description: 'Gol - Lewandowski' },
          { type: 'goal', minute: 71, team: 'home', player: 'Vinicius', description: 'Gol - Vinicius' },
          { type: 'yellow_card', minute: 74, team: 'home', player: 'Modric', description: 'Sarı kart - Modric' }
        ]
      },
      {
        id: 'demo_3',
        homeTeam: 'Manchester City',
        awayTeam: 'Liverpool',
        score: { fullTime: { home: 0, away: 2 }, halfTime: { home: 0, away: 1 } },
        minute: 85,
        status: 'IN_PLAY',
        competition: 'Premier League',
        startTime: new Date().toISOString(),
        events: [
          { type: 'goal', minute: 28, team: 'away', player: 'Salah', description: 'Gol - Salah' },
          { type: 'goal', minute: 58, team: 'away', player: 'Mane', description: 'Gol - Mane' },
          { type: 'yellow_card', minute: 82, team: 'home', player: 'De Bruyne', description: 'Sarı kart - De Bruyne' }
        ]
      }
    ];
  }

  getDemoMatchDetails(matchId) {
    const match = this.getDemoMatches().find(m => m.id === matchId) || this.getDemoMatches()[0];
    
    return {
      match: {
        ...match,
        homeTeam: {
          name: match.homeTeam,
          id: 1,
          crest: `https://via.placeholder.com/50x50?text=${match.homeTeam.charAt(0)}`
        },
        awayTeam: {
          name: match.awayTeam,
          id: 2,
          crest: `https://via.placeholder.com/50x50?text=${match.awayTeam.charAt(0)}`
        },
        statistics: {
          possession: { home: 58, away: 42 },
          shots: { home: 12, away: 8 },
          corners: { home: 6, away: 4 },
          fouls: { home: 11, away: 14 }
        }
      },
      predictions: {
        goal: {
          probability: 0.73,
          confidence: 0.85,
          timeWindow: '5-15 dakika',
          factors: ['Yüksek tempo', 'Son dakika baskısı']
        },
        corner: {
          probability: 0.45,
          confidence: 0.78,
          timeWindow: '2-8 dakika',
          factors: ['Ofansif oyun']
        },
        yellow_card: {
          probability: 0.62,
          confidence: 0.72,
          timeWindow: '3-10 dakika',
          factors: ['Artan gerginlik', 'Son dakika']
        },
        red_card: {
          probability: 0.12,
          confidence: 0.65,
          timeWindow: '10-20 dakika',
          factors: ['Yüksek gerginlik']
        },
        substitution: {
          probability: 0.89,
          confidence: 0.95,
          timeWindow: '2-5 dakika',
          factors: ['Son dakika', 'Taktik değişiklik']
        }
      },
      analysis: {
        momentum: { home: 0.7, away: 0.4, overall: 0.6, direction: 'home' },
        pressure: { home: 0.8, away: 0.6, overall: 0.85 },
        gameState: {
          phase: match.minute > 75 ? 'Son dakikalar' : 'Kritik dönem',
          intensity: 0.8,
          balance: 'Ev sahibi avantajlı',
          tempo: 'Yüksek tempo',
          control: 'Ev sahibi kontrol'
        },
        insights: [
          {
            type: 'momentum',
            priority: 'high',
            message: 'Ev sahibi takımda güçlü momentum',
            prediction: 'Yakın zamanda gol olasılığı yüksek'
          },
          {
            type: 'time',
            priority: 'high',
            message: 'Kritik zaman dilimi',
            prediction: 'Son dakika gerginliği artıyor'
          }
        ],
        criticalFactors: [
          {
            type: 'time',
            description: 'Maçın son dakikaları',
            impact: 'high',
            affects: ['goal', 'card', 'substitution']
          }
        ]
      }
    };
  }

  // Utility methods
  formatErrorMessage(error) {
    if (error.response?.data?.message) {
      return error.response.data.message;
    } else if (error.message) {
      return error.message;
    }
    return 'Beklenmeyen bir hata oluştu';
  }

  // Health check
  async healthCheck() {
    try {
      const response = await this.api.get('/health');
      return response.data;
    } catch (error) {
      console.error('Health check failed:', error);
      return { status: 'error', message: 'Server unreachable' };
    }
  }
}

// Export singleton instance
export const ApiService = new ApiServiceClass();