import axios from 'axios';

export class SportsDataAPI {
  constructor() {
    this.baseURL = 'https://api.football-data.org/v4';
    this.apiKey = process.env.FOOTBALL_API_KEY || 'demo_key';
    this.headers = {
      'X-Auth-Token': this.apiKey,
      'Content-Type': 'application/json'
    };
    
    // Backup demo data for development
    this.demoData = this.initializeDemoData();
  }
  
  async getLiveMatches() {
    try {
      // Try real API first
      if (this.apiKey !== 'demo_key') {
        const response = await axios.get(`${this.baseURL}/matches`, {
          headers: this.headers,
          params: {
            status: 'LIVE',
            limit: 20
          }
        });
        return this.formatMatches(response.data.matches);
      }
      
      // Fallback to demo data
      return this.generateLiveDemoMatches();
    } catch (error) {
      console.warn('API call failed, using demo data:', error.message);
      return this.generateLiveDemoMatches();
    }
  }
  
  async getMatchDetails(matchId) {
    try {
      if (this.apiKey !== 'demo_key') {
        const response = await axios.get(`${this.baseURL}/matches/${matchId}`, {
          headers: this.headers
        });
        return this.formatMatchDetails(response.data);
      }
      
      return this.getDemoMatchDetails(matchId);
    } catch (error) {
      console.warn('API call failed, using demo data:', error.message);
      return this.getDemoMatchDetails(matchId);
    }
  }
  
  async getTeamStats(teamId) {
    try {
      if (this.apiKey !== 'demo_key') {
        const response = await axios.get(`${this.baseURL}/teams/${teamId}`, {
          headers: this.headers
        });
        return response.data;
      }
      
      return this.getDemoTeamStats(teamId);
    } catch (error) {
      console.warn('API call failed, using demo data:', error.message);
      return this.getDemoTeamStats(teamId);
    }
  }
  
  formatMatches(matches) {
    return matches.map(match => ({
      id: match.id,
      homeTeam: match.homeTeam.name,
      awayTeam: match.awayTeam.name,
      score: match.score,
      minute: match.minute || 0,
      status: match.status,
      competition: match.competition.name,
      startTime: match.utcDate,
      events: this.extractEvents(match)
    }));
  }
  
  formatMatchDetails(match) {
    return {
      id: match.id,
      homeTeam: {
        name: match.homeTeam.name,
        id: match.homeTeam.id,
        crest: match.homeTeam.crest
      },
      awayTeam: {
        name: match.awayTeam.name,
        id: match.awayTeam.id,
        crest: match.awayTeam.crest
      },
      score: match.score,
      minute: match.minute || 0,
      status: match.status,
      competition: match.competition,
      events: this.extractEvents(match),
      statistics: this.extractStatistics(match),
      startTime: match.utcDate
    };
  }
  
  extractEvents(match) {
    // Extract goals, cards, corners, etc.
    const events = [];
    
    if (match.goals) {
      match.goals.forEach(goal => {
        events.push({
          type: 'goal',
          minute: goal.minute,
          team: goal.team,
          player: goal.scorer?.name,
          description: `Gol - ${goal.scorer?.name || 'Bilinmeyen'}`
        });
      });
    }
    
    if (match.bookings) {
      match.bookings.forEach(booking => {
        events.push({
          type: booking.card === 'YELLOW_CARD' ? 'yellow_card' : 'red_card',
          minute: booking.minute,
          team: booking.team,
          player: booking.player?.name,
          description: `${booking.card === 'YELLOW_CARD' ? 'Sarı' : 'Kırmızı'} kart - ${booking.player?.name || 'Bilinmeyen'}`
        });
      });
    }
    
    return events.sort((a, b) => a.minute - b.minute);
  }
  
  extractStatistics(match) {
    return {
      possession: {
        home: Math.floor(Math.random() * 30) + 40,
        away: Math.floor(Math.random() * 30) + 40
      },
      shots: {
        home: Math.floor(Math.random() * 15) + 5,
        away: Math.floor(Math.random() * 15) + 5
      },
      corners: {
        home: Math.floor(Math.random() * 8) + 2,
        away: Math.floor(Math.random() * 8) + 2
      },
      fouls: {
        home: Math.floor(Math.random() * 10) + 5,
        away: Math.floor(Math.random() * 10) + 5
      }
    };
  }
  
  // Demo data methods
  initializeDemoData() {
    return {
      teams: [
        { id: 1, name: 'Galatasaray', strength: 85 },
        { id: 2, name: 'Fenerbahçe', strength: 83 },
        { id: 3, name: 'Beşiktaş', strength: 80 },
        { id: 4, name: 'Trabzonspor', strength: 75 },
        { id: 5, name: 'Real Madrid', strength: 92 },
        { id: 6, name: 'Barcelona', strength: 90 },
        { id: 7, name: 'Manchester City', strength: 94 },
        { id: 8, name: 'Liverpool', strength: 88 }
      ]
    };
  }
  
  generateLiveDemoMatches() {
    const matches = [];
    const teams = this.demoData.teams;
    
    for (let i = 0; i < 6; i++) {
      const homeTeam = teams[Math.floor(Math.random() * teams.length)];
      const awayTeam = teams[Math.floor(Math.random() * teams.length)];
      
      if (homeTeam.id === awayTeam.id) continue;
      
      const minute = Math.floor(Math.random() * 90) + 1;
      const homeGoals = Math.floor(Math.random() * 4);
      const awayGoals = Math.floor(Math.random() * 4);
      
      matches.push({
        id: `demo_${i + 1}`,
        homeTeam: homeTeam.name,
        awayTeam: awayTeam.name,
        score: {
          fullTime: { home: homeGoals, away: awayGoals },
          halfTime: { home: Math.floor(homeGoals * 0.6), away: Math.floor(awayGoals * 0.6) }
        },
        minute,
        status: 'IN_PLAY',
        competition: 'Süper Lig',
        startTime: new Date().toISOString(),
        events: this.generateDemoEvents(minute, homeGoals, awayGoals)
      });
    }
    
    return matches;
  }
  
  getDemoMatchDetails(matchId) {
    const teams = this.demoData.teams;
    const homeTeam = teams[Math.floor(Math.random() * teams.length)];
    const awayTeam = teams[Math.floor(Math.random() * teams.length)];
    
    const minute = Math.floor(Math.random() * 90) + 1;
    const homeGoals = Math.floor(Math.random() * 4);
    const awayGoals = Math.floor(Math.random() * 4);
    
    return {
      id: matchId,
      homeTeam: {
        name: homeTeam.name,
        id: homeTeam.id,
        crest: `https://via.placeholder.com/50x50?text=${homeTeam.name.charAt(0)}`
      },
      awayTeam: {
        name: awayTeam.name,
        id: awayTeam.id,
        crest: `https://via.placeholder.com/50x50?text=${awayTeam.name.charAt(0)}`
      },
      score: {
        fullTime: { home: homeGoals, away: awayGoals },
        halfTime: { home: Math.floor(homeGoals * 0.6), away: Math.floor(awayGoals * 0.6) }
      },
      minute,
      status: 'IN_PLAY',
      competition: { name: 'Süper Lig' },
      events: this.generateDemoEvents(minute, homeGoals, awayGoals),
      statistics: this.extractStatistics({}),
      startTime: new Date().toISOString()
    };
  }
  
  generateDemoEvents(minute, homeGoals, awayGoals) {
    const events = [];
    
    // Generate goal events
    for (let i = 0; i < homeGoals; i++) {
      events.push({
        type: 'goal',
        minute: Math.floor(Math.random() * minute),
        team: 'home',
        player: `Oyuncu ${i + 1}`,
        description: `Gol - Oyuncu ${i + 1}`
      });
    }
    
    for (let i = 0; i < awayGoals; i++) {
      events.push({
        type: 'goal',
        minute: Math.floor(Math.random() * minute),
        team: 'away',
        player: `Oyuncu ${i + 1}`,
        description: `Gol - Oyuncu ${i + 1}`
      });
    }
    
    // Generate card events
    const cardCount = Math.floor(Math.random() * 5);
    for (let i = 0; i < cardCount; i++) {
      events.push({
        type: Math.random() > 0.8 ? 'red_card' : 'yellow_card',
        minute: Math.floor(Math.random() * minute),
        team: Math.random() > 0.5 ? 'home' : 'away',
        player: `Oyuncu ${i + 1}`,
        description: `${Math.random() > 0.8 ? 'Kırmızı' : 'Sarı'} kart - Oyuncu ${i + 1}`
      });
    }
    
    return events.sort((a, b) => a.minute - b.minute);
  }
  
  getDemoTeamStats(teamId) {
    return {
      id: teamId,
      name: 'Demo Team',
      strength: Math.floor(Math.random() * 30) + 70,
      recentForm: ['W', 'L', 'W', 'D', 'W'],
      goalsScored: Math.floor(Math.random() * 20) + 10,
      goalsConceded: Math.floor(Math.random() * 15) + 5
    };
  }
}