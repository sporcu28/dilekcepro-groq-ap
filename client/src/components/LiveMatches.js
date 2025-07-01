import React from 'react';
import { motion } from 'framer-motion';
import { Play, Clock, TrendingUp } from 'lucide-react';

const LiveMatches = ({ matches, onMatchSelect }) => {
  const formatTime = (minute) => {
    if (minute > 45 && minute <= 90) {
      return `${minute}'`;
    } else if (minute > 90) {
      return `90+${minute - 90}'`;
    }
    return `${minute}'`;
  };

  const getMatchStatus = (status, minute) => {
    switch (status) {
      case 'IN_PLAY':
        return (
          <div className="flex items-center space-x-1">
            <div className="live-indicator">CANLI</div>
            <span className="text-sm text-gray-600">{formatTime(minute)}</span>
          </div>
        );
      case 'HALFTIME':
        return <span className="text-sm text-yellow-600">Devre Arası</span>;
      case 'FINISHED':
        return <span className="text-sm text-gray-600">Bitti</span>;
      default:
        return <span className="text-sm text-gray-600">{status}</span>;
    }
  };

  const containerVariants = {
    hidden: { opacity: 0 },
    visible: {
      opacity: 1,
      transition: {
        staggerChildren: 0.1
      }
    }
  };

  const itemVariants = {
    hidden: { opacity: 0, y: 20 },
    visible: { opacity: 1, y: 0 }
  };

  return (
    <motion.div
      variants={containerVariants}
      initial="hidden"
      animate="visible"
      className="space-y-4"
    >
      <div className="flex items-center justify-between mb-6">
        <h2 className="text-2xl font-bold text-white flex items-center">
          <Play className="w-6 h-6 mr-2" />
          Canlı Maçlar
        </h2>
        <span className="text-white/70 text-sm">
          {matches.length} maç devam ediyor
        </span>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        {matches.map((match) => (
          <motion.div
            key={match.id}
            variants={itemVariants}
            whileHover={{ scale: 1.02 }}
            whileTap={{ scale: 0.98 }}
            className="card cursor-pointer group"
            onClick={() => onMatchSelect(match)}
          >
            <div className="space-y-4">
              {/* Match Header */}
              <div className="flex items-center justify-between">
                <span className="text-sm text-gray-600">{match.competition}</span>
                {getMatchStatus(match.status, match.minute)}
              </div>

              {/* Teams and Score */}
              <div className="space-y-3">
                <div className="flex items-center justify-between">
                  <div className="flex items-center space-x-2">
                    <div className="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                      <span className="text-xs font-semibold">
                        {match.homeTeam?.charAt(0) || 'H'}
                      </span>
                    </div>
                    <span className="font-medium">{match.homeTeam}</span>
                  </div>
                  <span className="text-2xl font-bold">
                    {match.score?.fullTime?.home || 0}
                  </span>
                </div>

                <div className="flex items-center justify-between">
                  <div className="flex items-center space-x-2">
                    <div className="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                      <span className="text-xs font-semibold">
                        {match.awayTeam?.charAt(0) || 'A'}
                      </span>
                    </div>
                    <span className="font-medium">{match.awayTeam}</span>
                  </div>
                  <span className="text-2xl font-bold">
                    {match.score?.fullTime?.away || 0}
                  </span>
                </div>
              </div>

              {/* Recent Events */}
              {match.events && match.events.length > 0 && (
                <div className="border-t pt-3">
                  <h4 className="text-sm font-medium text-gray-700 mb-2">Son Olaylar</h4>
                  <div className="space-y-1">
                    {match.events.slice(-2).map((event, index) => (
                      <div key={index} className="flex items-center justify-between text-xs">
                        <span className="text-gray-600">
                          {event.minute}' {event.description}
                        </span>
                        <span className={`px-2 py-1 rounded text-xs ${
                          event.type === 'goal' ? 'bg-green-100 text-green-600' :
                          event.type === 'yellow_card' ? 'bg-yellow-100 text-yellow-600' :
                          event.type === 'red_card' ? 'bg-red-100 text-red-600' :
                          'bg-gray-100 text-gray-600'
                        }`}>
                          {event.type === 'goal' ? '⚽' :
                           event.type === 'yellow_card' ? '🟨' :
                           event.type === 'red_card' ? '🟥' : '⚽'}
                        </span>
                      </div>
                    ))}
                  </div>
                </div>
              )}

              {/* AI Prediction Teaser */}
              <div className="border-t pt-3">
                <div className="flex items-center justify-between">
                  <div className="flex items-center space-x-2">
                    <TrendingUp className="w-4 h-4 text-blue-600" />
                    <span className="text-sm font-medium text-blue-600">AI Tahmin</span>
                  </div>
                  <span className="text-xs text-gray-500">Detaylar için tıklayın</span>
                </div>
                
                <div className="mt-2 grid grid-cols-2 gap-2 text-xs">
                  <div className="bg-green-50 p-2 rounded">
                    <div className="text-green-600 font-medium">Gol</div>
                    <div className="text-green-500">%73 olasılık</div>
                  </div>
                  <div className="bg-blue-50 p-2 rounded">
                    <div className="text-blue-600 font-medium">Korner</div>
                    <div className="text-blue-500">%45 olasılık</div>
                  </div>
                </div>
              </div>

              {/* View Details Button */}
              <button className="w-full btn btn-primary group-hover:bg-gradient-to-r group-hover:from-blue-600 group-hover:to-purple-600 transition-all duration-300">
                <TrendingUp className="w-4 h-4 mr-2" />
                Detaylı Analiz & AI Tahminleri
              </button>
            </div>
          </motion.div>
        ))}
      </div>

      {/* Features Info */}
      <motion.div
        initial={{ opacity: 0, y: 20 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ delay: 0.5 }}
        className="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4"
      >
        <div className="glass-card p-6 text-center text-white">
          <div className="text-2xl mb-2">🤖</div>
          <h3 className="font-semibold mb-2">AI Tahmin Motoru</h3>
          <p className="text-sm text-white/80">
            TensorFlow.js ile gelişmiş makine öğrenmesi algoritmaları
          </p>
        </div>

        <div className="glass-card p-6 text-center text-white">
          <div className="text-2xl mb-2">⚡</div>
          <h3 className="font-semibold mb-2">Gerçek Zamanlı</h3>
          <p className="text-sm text-white/80">
            30 saniyede bir güncellenen canlı maç verileri
          </p>
        </div>

        <div className="glass-card p-6 text-center text-white">
          <div className="text-2xl mb-2">🎯</div>
          <h3 className="font-semibold mb-2">%100 Doğruluk Hedefi</h3>
          <p className="text-sm text-white/80">
            Gelişmiş analiz ve tahmin sistemleri
          </p>
        </div>
      </motion.div>
    </motion.div>
  );
};

export default LiveMatches;