import React from 'react';
import { motion } from 'framer-motion';
import { Target, Clock, TrendingUp, Info } from 'lucide-react';

const PredictionCard = ({ eventType, prediction }) => {
  const getEventIcon = (type) => {
    switch (type) {
      case 'goal': return '⚽';
      case 'corner': return '📐';
      case 'yellow_card': return '🟨';
      case 'red_card': return '🟥';
      case 'substitution': return '🔄';
      case 'offside': return '🚩';
      case 'foul': return '⚠️';
      default: return '⚽';
    }
  };

  const getEventName = (type) => {
    switch (type) {
      case 'goal': return 'Gol';
      case 'corner': return 'Korner';
      case 'yellow_card': return 'Sarı Kart';
      case 'red_card': return 'Kırmızı Kart';
      case 'substitution': return 'Oyuncu Değişikliği';
      case 'offside': return 'Ofsayt';
      case 'foul': return 'Faul';
      default: return type;
    }
  };

  const getConfidenceColor = (confidence) => {
    if (confidence >= 0.8) return 'text-green-600';
    if (confidence >= 0.6) return 'text-yellow-600';
    return 'text-red-600';
  };

  const getProbabilityColor = (probability) => {
    if (probability >= 0.7) return 'from-green-500 to-green-600';
    if (probability >= 0.4) return 'from-yellow-500 to-yellow-600';
    return 'from-red-500 to-red-600';
  };

  return (
    <motion.div
      whileHover={{ scale: 1.02 }}
      className="bg-gradient-to-br from-white to-gray-50 p-6 rounded-xl shadow-lg border border-gray-200"
    >
      {/* Header */}
      <div className="flex items-center justify-between mb-4">
        <div className="flex items-center space-x-3">
          <span className="text-3xl">{getEventIcon(eventType)}</span>
          <div>
            <h3 className="font-bold text-lg">{getEventName(eventType)}</h3>
            <p className="text-sm text-gray-600">AI Tahmin</p>
          </div>
        </div>
        <Target className="w-6 h-6 text-blue-500" />
      </div>

      {/* Probability */}
      <div className="mb-4">
        <div className="flex items-center justify-between mb-2">
          <span className="text-sm font-medium text-gray-700">Olasılık</span>
          <span className="text-2xl font-bold">
            %{Math.round(prediction.probability * 100)}
          </span>
        </div>
        
        <div className="w-full bg-gray-200 rounded-full h-3 mb-2">
          <motion.div
            initial={{ width: 0 }}
            animate={{ width: `${prediction.probability * 100}%` }}
            transition={{ duration: 1, ease: "easeOut" }}
            className={`h-3 rounded-full bg-gradient-to-r ${getProbabilityColor(prediction.probability)}`}
          />
        </div>
        
        <div className="flex items-center space-x-1">
          <Info className="w-4 h-4 text-gray-500" />
          <span className={`text-sm font-medium ${getConfidenceColor(prediction.confidence)}`}>
            Güven: %{Math.round(prediction.confidence * 100)}
          </span>
        </div>
      </div>

      {/* Time Window */}
      <div className="mb-4 p-3 bg-blue-50 rounded-lg">
        <div className="flex items-center space-x-2 mb-1">
          <Clock className="w-4 h-4 text-blue-600" />
          <span className="text-sm font-medium text-blue-800">Zaman Aralığı</span>
        </div>
        <span className="text-blue-700 font-semibold">{prediction.timeWindow}</span>
      </div>

      {/* Factors */}
      {prediction.factors && prediction.factors.length > 0 && (
        <div className="mb-4">
          <div className="flex items-center space-x-2 mb-2">
            <TrendingUp className="w-4 h-4 text-purple-600" />
            <span className="text-sm font-medium text-gray-700">Etkileyen Faktörler</span>
          </div>
          <div className="space-y-1">
            {prediction.factors.map((factor, index) => (
              <span
                key={index}
                className="inline-block px-2 py-1 bg-purple-100 text-purple-700 text-xs rounded-full mr-1 mb-1"
              >
                {factor}
              </span>
            ))}
          </div>
        </div>
      )}

      {/* Recommendation */}
      <div className="border-t pt-3">
        <p className="text-sm text-gray-600 italic">
          {prediction.probability > 0.7 ? (
            <span className="text-green-600 font-medium">🎯 Yüksek ihtimal - Bu olay gerçekleşebilir</span>
          ) : prediction.probability > 0.4 ? (
            <span className="text-yellow-600 font-medium">⚠️ Orta ihtimal - Dikkatli takip edin</span>
          ) : (
            <span className="text-gray-600">📊 Düşük ihtimal - Az olası</span>
          )}
        </p>
      </div>

      {/* AI Badge */}
      <div className="mt-3 flex justify-end">
        <span className="inline-flex items-center px-2 py-1 rounded-full text-xs bg-gradient-to-r from-blue-500 to-purple-600 text-white">
          <span className="w-2 h-2 bg-white rounded-full mr-1 animate-pulse"></span>
          AI Powered
        </span>
      </div>
    </motion.div>
  );
};

export default PredictionCard;