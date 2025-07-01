import { io } from 'socket.io-client';
import toast from 'react-hot-toast';

class SocketServiceClass {
  constructor() {
    this.socket = null;
    this.connected = false;
    this.listeners = new Map();
  }

  connect() {
    try {
      this.socket = io(process.env.REACT_APP_API_URL || 'http://localhost:3000', {
        transports: ['websocket', 'polling'],
        timeout: 20000,
        autoConnect: true
      });

      this.socket.on('connect', () => {
        console.log('🔌 Connected to AI Sports Predictor server');
        this.connected = true;
        this.emit('connect');
        toast.success('Canlı veri akışı başlatıldı! 🚀');
      });

      this.socket.on('disconnect', (reason) => {
        console.log('🔌 Disconnected from server:', reason);
        this.connected = false;
        this.emit('disconnect');
        toast.error('Bağlantı kesildi. Yeniden bağlanılıyor...');
      });

      this.socket.on('connect_error', (error) => {
        console.error('Connection error:', error);
        toast.error('Bağlantı hatası. Lütfen tekrar deneyin.');
      });

      // Live match updates
      this.socket.on('match-update', (data) => {
        console.log('📊 Match update received:', data);
        this.emit('match-update', data);
        
        if (data.match && data.predictions) {
          toast.success(`${data.match.homeTeam} vs ${data.match.awayTeam} - Yeni tahmin!`);
        }
      });

      // AI event predictions
      this.socket.on('event-prediction', (prediction) => {
        console.log('🤖 AI Prediction:', prediction);
        this.emit('event-prediction', prediction);
        
        if (prediction.probability > 0.7) {
          toast.success(`🎯 Yüksek İhtimal: ${prediction.nextEventType} - %${Math.round(prediction.probability * 100)}`);
        }
      });

      // Reconnection logic
      this.socket.on('reconnect', (attemptNumber) => {
        console.log('🔄 Reconnected after', attemptNumber, 'attempts');
        toast.success('Bağlantı yeniden kuruldu! ✨');
      });

      this.socket.on('reconnect_attempt', (attemptNumber) => {
        console.log('🔄 Reconnection attempt:', attemptNumber);
      });

    } catch (error) {
      console.error('Error connecting to socket:', error);
      toast.error('Sunucu bağlantısı kurulamadı.');
    }
  }

  disconnect() {
    if (this.socket) {
      this.socket.disconnect();
      this.socket = null;
      this.connected = false;
      this.listeners.clear();
    }
  }

  subscribeToMatch(matchId) {
    if (this.socket && this.connected) {
      this.socket.emit('subscribe-match', matchId);
      console.log('🔔 Subscribed to match:', matchId);
      toast.success('Maç güncellemeleri aktifleştirildi! 📱');
    }
  }

  unsubscribeFromMatch(matchId) {
    if (this.socket && this.connected) {
      this.socket.emit('unsubscribe-match', matchId);
      console.log('🔕 Unsubscribed from match:', matchId);
    }
  }

  // Event listener system
  on(event, callback) {
    if (!this.listeners.has(event)) {
      this.listeners.set(event, new Set());
    }
    this.listeners.get(event).add(callback);
  }

  off(event, callback) {
    if (this.listeners.has(event)) {
      this.listeners.get(event).delete(callback);
    }
  }

  emit(event, data) {
    if (this.listeners.has(event)) {
      this.listeners.get(event).forEach(callback => {
        try {
          callback(data);
        } catch (error) {
          console.error('Error in socket event callback:', error);
        }
      });
    }
  }

  // Convenience methods
  onConnect(callback) {
    this.on('connect', callback);
  }

  onDisconnect(callback) {
    this.on('disconnect', callback);
  }

  onMatchUpdate(callback) {
    this.on('match-update', callback);
  }

  onEventPrediction(callback) {
    this.on('event-prediction', callback);
  }

  // Get connection status
  isConnected() {
    return this.connected && this.socket?.connected;
  }

  // Send custom messages
  sendMessage(event, data) {
    if (this.socket && this.connected) {
      this.socket.emit(event, data);
    } else {
      console.warn('Socket not connected, cannot send message:', event);
    }
  }
}

// Export singleton instance
export const SocketService = new SocketServiceClass();