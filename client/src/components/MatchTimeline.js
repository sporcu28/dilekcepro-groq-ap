import React from 'react';
import { motion } from 'framer-motion';

const MatchTimeline = ({ events }) => {
  const getEventIcon = (type) => {
    switch (type) {
      case 'goal': return '⚽';
      case 'yellow_card': return '🟨';
      case 'red_card': return '🟥';
      case 'substitution': return '🔄';
      case 'corner': return '📐';
      case 'foul': return '⚠️';
      case 'offside': return '🚩';
      default: return '⚽';
    }
  };

  const getEventColor = (type) => {
    switch (type) {
      case 'goal': return 'border-green-400 bg-green-50';
      case 'yellow_card': return 'border-yellow-400 bg-yellow-50';
      case 'red_card': return 'border-red-400 bg-red-50';
      case 'substitution': return 'border-blue-400 bg-blue-50';
      default: return 'border-gray-400 bg-gray-50';
    }
  };

  const sortedEvents = [...events].sort((a, b) => b.minute - a.minute);

  return (
    <div className="space-y-4">
      <h3 className="text-lg font-semibold">Maç Olayları</h3>
      
      {sortedEvents.length === 0 ? (
        <div className="text-center py-8 text-gray-500">
          <p>Henüz kayıtlı olay bulunmuyor</p>
        </div>
      ) : (
        <div className="timeline">
          {sortedEvents.map((event, index) => (
            <motion.div
              key={index}
              initial={{ opacity: 0, x: -20 }}
              animate={{ opacity: 1, x: 0 }}
              transition={{ delay: index * 0.1 }}
              className={`timeline-item p-4 rounded-lg border-l-4 ${getEventColor(event.type)}`}
            >
              <div className="flex items-start space-x-3">
                <div className="flex-shrink-0">
                  <span className="text-2xl">{getEventIcon(event.type)}</span>
                </div>
                
                <div className="flex-1 min-w-0">
                  <div className="flex items-center justify-between">
                    <p className="font-medium text-gray-900">
                      {event.description || `${event.type} olayı`}
                    </p>
                    <span className="text-sm font-bold text-gray-700">
                      {event.minute}'
                    </span>
                  </div>
                  
                  {event.player && (
                    <p className="text-sm text-gray-600 mt-1">
                      Oyuncu: {event.player}
                    </p>
                  )}
                  
                  {event.team && (
                    <p className="text-xs text-gray-500 mt-1">
                      Takım: {event.team === 'home' ? 'Ev Sahibi' : 'Misafir'}
                    </p>
                  )}
                </div>
              </div>
            </motion.div>
          ))}
        </div>
      )}
      
      {/* Timeline Legend */}
      <div className="mt-6 p-4 bg-gray-50 rounded-lg">
        <h4 className="font-medium mb-3">Olay Türleri</h4>
        <div className="grid grid-cols-2 md:grid-cols-4 gap-2 text-sm">
          <div className="flex items-center space-x-2">
            <span>⚽</span>
            <span>Gol</span>
          </div>
          <div className="flex items-center space-x-2">
            <span>🟨</span>
            <span>Sarı Kart</span>
          </div>
          <div className="flex items-center space-x-2">
            <span>🟥</span>
            <span>Kırmızı Kart</span>
          </div>
          <div className="flex items-center space-x-2">
            <span>🔄</span>
            <span>Değişiklik</span>
          </div>
          <div className="flex items-center space-x-2">
            <span>📐</span>
            <span>Korner</span>
          </div>
          <div className="flex items-center space-x-2">
            <span>⚠️</span>
            <span>Faul</span>
          </div>
          <div className="flex items-center space-x-2">
            <span>🚩</span>
            <span>Ofsayt</span>
          </div>
        </div>
      </div>
    </div>
  );
};

export default MatchTimeline;