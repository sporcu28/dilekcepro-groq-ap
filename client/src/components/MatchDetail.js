import React, { useState, useEffect } from 'react';
import { motion } from 'framer-motion';
import { ArrowLeft, Target, Activity, Brain, Clock, TrendingUp, AlertTriangle } from 'lucide-react';
import PredictionCard from './PredictionCard';
import MatchTimeline from './MatchTimeline';
import MatchStats from './MatchStats';
import { SocketService } from '../services/socketService';

const MatchDetail = ({ match, onBack }) => {
  const [activeTab, setActiveTab] = useState('predictions');
  const [liveUpdates, setLiveUpdates] = useState([]);

  useEffect(() => {
    // Listen for AI predictions
    const handleEventPrediction = (prediction) => {
      setLiveUpdates(prev => [{
        id: Date.now(),
        timestamp: new Date(),
        type: 'prediction',
        data: prediction
      }, ...prev.slice(0, 9)]); // Keep last 10 updates
    };

    SocketService.onEventPrediction(handleEventPrediction);

    return () => {
      SocketService.off('event-prediction', handleEventPrediction);
    };
  }, []);

  const formatTime = (minute) => {
    if (minute > 45 && minute <= 90) {
      return `${minute}'`;
    } else if (minute > 90) {
      return `90+${minute - 90}'`;
    }
    return `${minute}'`;
  };

  const tabs = [
    { id: 'predictions', label: 'AI Tahminler', icon: Brain },
    { id: 'analysis', label: 'Maç Analizi', icon: Activity },
    { id: 'timeline', label: 'Olaylar', icon: Clock },
    { id: 'stats', label: 'İstatistikler', icon: TrendingUp }
  ];

  const topPredictions = match.predictions ? 
    Object.entries(match.predictions)
      .sort(([,a], [,b]) => b.probability - a.probability)
      .slice(0, 3) : [];

  return (
    <motion.div
      initial={{ opacity: 0 }}
      animate={{ opacity: 1 }}
      exit={{ opacity: 0 }}
      className="space-y-6"
    >
      {/* Header */}
      <div className="card">
        <div className="flex items-center justify-between mb-6">
          <button
            onClick={onBack}
            className="btn btn-secondary"
          >
            <ArrowLeft className="w-4 h-4 mr-2" />
            Geri
          </button>
          
          <div className="flex items-center space-x-2">
            <div className="live-indicator">CANLI</div>
            <span className="text-lg font-semibold">{formatTime(match.match?.minute || 0)}</span>
          </div>
        </div>

        {/* Teams and Score */}
        <div className="grid grid-cols-3 gap-6 items-center mb-6">
          <div className="text-center">
            <div className="w-16 h-16 mx-auto mb-3 bg-gray-200 rounded-full flex items-center justify-center">
              <span className="text-xl font-bold">
                {match.match?.homeTeam?.name?.charAt(0) || 'H'}
              </span>
            </div>
            <h3 className="font-bold text-lg">{match.match?.homeTeam?.name || 'Home Team'}</h3>
          </div>

          <div className="text-center">
            <div className="text-4xl font-bold mb-2">
              {match.match?.score?.fullTime?.home || 0} - {match.match?.score?.fullTime?.away || 0}
            </div>
            <div className="text-sm text-gray-600">
              İlk Yarı: {match.match?.score?.halfTime?.home || 0} - {match.match?.score?.halfTime?.away || 0}
            </div>
            <div className="text-sm text-gray-600 mt-1">
              {match.match?.competition?.name || 'League'}
            </div>
          </div>

          <div className="text-center">
            <div className="w-16 h-16 mx-auto mb-3 bg-gray-200 rounded-full flex items-center justify-center">
              <span className="text-xl font-bold">
                {match.match?.awayTeam?.name?.charAt(0) || 'A'}
              </span>
            </div>
            <h3 className="font-bold text-lg">{match.match?.awayTeam?.name || 'Away Team'}</h3>
          </div>
        </div>

        {/* Game State */}
        {match.analysis?.gameState && (
          <div className="grid grid-cols-2 md:grid-cols-4 gap-4 p-4 bg-gray-50 rounded-lg">
            <div className="text-center">
              <div className="text-sm text-gray-600">Fase</div>
              <div className="font-semibold">{match.analysis.gameState.phase}</div>
            </div>
            <div className="text-center">
              <div className="text-sm text-gray-600">Yoğunluk</div>
              <div className="font-semibold">
                {Math.round(match.analysis.gameState.intensity * 100)}%
              </div>
            </div>
            <div className="text-center">
              <div className="text-sm text-gray-600">Denge</div>
              <div className="font-semibold">{match.analysis.gameState.balance}</div>
            </div>
            <div className="text-center">
              <div className="text-sm text-gray-600">Tempo</div>
              <div className="font-semibold">{match.analysis.gameState.tempo}</div>
            </div>
          </div>
        )}
      </div>

      {/* Live Updates */}
      {liveUpdates.length > 0 && (
        <motion.div
          initial={{ opacity: 0, y: -20 }}
          animate={{ opacity: 1, y: 0 }}
          className="card bg-gradient-to-r from-blue-50 to-indigo-50"
        >
          <h3 className="font-semibold mb-3 flex items-center">
            <Target className="w-5 h-5 mr-2 text-blue-600" />
            Canlı AI Tahminleri
          </h3>
          <div className="space-y-2 max-h-32 overflow-y-auto">
            {liveUpdates.slice(0, 3).map((update) => (
              <div key={update.id} className="flex items-center justify-between text-sm">
                <span>
                  {update.data.nextEventType} - %{Math.round(update.data.probability * 100)} olasılık
                </span>
                <span className="text-xs text-gray-500">
                  {update.timestamp.toLocaleTimeString()}
                </span>
              </div>
            ))}
          </div>
        </motion.div>
      )}

      {/* Top Predictions Overview */}
      <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
        {topPredictions.map(([eventType, prediction]) => (
          <motion.div
            key={eventType}
            whileHover={{ scale: 1.02 }}
            className="card bg-gradient-to-br from-white to-gray-50"
          >
            <div className="flex items-center justify-between mb-3">
              <h4 className="font-semibold capitalize">
                {eventType === 'yellow_card' ? 'Sarı Kart' :
                 eventType === 'red_card' ? 'Kırmızı Kart' :
                 eventType === 'corner' ? 'Korner' :
                 eventType === 'substitution' ? 'Değişiklik' :
                 eventType}
              </h4>
              <span className="text-2xl">
                {eventType === 'goal' ? '⚽' :
                 eventType === 'corner' ? '📐' :
                 eventType === 'yellow_card' ? '🟨' :
                 eventType === 'red_card' ? '🟥' :
                 eventType === 'substitution' ? '🔄' : '⚽'}
              </span>
            </div>
            
            <div className="space-y-2">
              <div className="flex justify-between">
                <span className="text-sm text-gray-600">Olasılık</span>
                <span className="font-bold text-lg">
                  %{Math.round(prediction.probability * 100)}
                </span>
              </div>
              
              <div className="confidence-bar">
                <div 
                  className="confidence-fill"
                  style={{ width: `${prediction.probability * 100}%` }}
                />
              </div>
              
              <div className="text-xs text-gray-600">
                Zaman: {prediction.timeWindow}
              </div>
            </div>
          </motion.div>
        ))}
      </div>

      {/* Tabs */}
      <div className="card">
        <div className="flex space-x-1 mb-6 bg-gray-100 p-1 rounded-lg">
          {tabs.map((tab) => (
            <button
              key={tab.id}
              onClick={() => setActiveTab(tab.id)}
              className={`flex-1 flex items-center justify-center py-2 px-4 rounded-md text-sm font-medium transition-all ${
                activeTab === tab.id
                  ? 'bg-white text-blue-600 shadow-sm'
                  : 'text-gray-600 hover:text-gray-800'
              }`}
            >
              <tab.icon className="w-4 h-4 mr-2" />
              {tab.label}
            </button>
          ))}
        </div>

        {/* Tab Content */}
        <div className="min-h-[400px]">
          {activeTab === 'predictions' && (
            <div className="space-y-6">
              <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                {match.predictions && Object.entries(match.predictions).map(([eventType, prediction]) => (
                  <PredictionCard
                    key={eventType}
                    eventType={eventType}
                    prediction={prediction}
                  />
                ))}
              </div>
            </div>
          )}

          {activeTab === 'analysis' && match.analysis && (
            <div className="space-y-6">
              {/* Momentum */}
              <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div className="bg-gray-50 p-4 rounded-lg">
                  <h4 className="font-semibold mb-3">Momentum</h4>
                  <div className="space-y-2">
                    <div className="flex justify-between">
                      <span>{match.match?.homeTeam?.name || 'Home'}</span>
                      <span>%{Math.round(match.analysis.momentum.home * 100)}</span>
                    </div>
                    <div className="confidence-bar">
                      <div 
                        className="confidence-fill bg-blue-500"
                        style={{ width: `${match.analysis.momentum.home * 100}%` }}
                      />
                    </div>
                    
                    <div className="flex justify-between">
                      <span>{match.match?.awayTeam?.name || 'Away'}</span>
                      <span>%{Math.round(match.analysis.momentum.away * 100)}</span>
                    </div>
                    <div className="confidence-bar">
                      <div 
                        className="confidence-fill bg-red-500"
                        style={{ width: `${match.analysis.momentum.away * 100}%` }}
                      />
                    </div>
                  </div>
                </div>

                <div className="bg-gray-50 p-4 rounded-lg">
                  <h4 className="font-semibold mb-3">Baskı</h4>
                  <div className="space-y-2">
                    <div className="flex justify-between">
                      <span>Genel Baskı</span>
                      <span>%{Math.round(match.analysis.pressure.overall * 100)}</span>
                    </div>
                    <div className="confidence-bar">
                      <div 
                        className="confidence-fill bg-orange-500"
                        style={{ width: `${match.analysis.pressure.overall * 100}%` }}
                      />
                    </div>
                  </div>
                </div>
              </div>

              {/* Insights */}
              {match.analysis.insights && match.analysis.insights.length > 0 && (
                <div>
                  <h4 className="font-semibold mb-3">AI Görüşleri</h4>
                  <div className="space-y-3">
                    {match.analysis.insights.map((insight, index) => (
                      <div
                        key={index}
                        className={`p-4 rounded-lg border-l-4 ${
                          insight.priority === 'high' ? 'bg-red-50 border-red-400' :
                          insight.priority === 'medium' ? 'bg-yellow-50 border-yellow-400' :
                          'bg-blue-50 border-blue-400'
                        }`}
                      >
                        <div className="flex items-start space-x-3">
                          <AlertTriangle className={`w-5 h-5 mt-0.5 ${
                            insight.priority === 'high' ? 'text-red-500' :
                            insight.priority === 'medium' ? 'text-yellow-500' :
                            'text-blue-500'
                          }`} />
                          <div>
                            <p className="font-medium">{insight.message}</p>
                            <p className="text-sm text-gray-600 mt-1">{insight.prediction}</p>
                          </div>
                        </div>
                      </div>
                    ))}
                  </div>
                </div>
              )}
            </div>
          )}

          {activeTab === 'timeline' && (
            <MatchTimeline events={match.match?.events || []} />
          )}

          {activeTab === 'stats' && (
            <MatchStats statistics={match.match?.statistics || {}} />
          )}
        </div>
      </div>
    </motion.div>
  );
};

export default MatchDetail;