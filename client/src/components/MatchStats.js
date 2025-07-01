import React from 'react';
import { motion } from 'framer-motion';
import { BarChart, Bar, XAxis, YAxis, CartesianGrid, Tooltip, ResponsiveContainer, PieChart, Pie, Cell } from 'recharts';

const MatchStats = ({ statistics }) => {
  const stats = {
    possession: { home: 50, away: 50 },
    shots: { home: 0, away: 0 },
    corners: { home: 0, away: 0 },
    fouls: { home: 0, away: 0 },
    ...statistics
  };

  const chartData = [
    {
      name: 'Şutlar',
      home: stats.shots.home,
      away: stats.shots.away,
    },
    {
      name: 'Kornerler',
      home: stats.corners.home,
      away: stats.corners.away,
    },
    {
      name: 'Fauller',
      home: stats.fouls.home,
      away: stats.fouls.away,
    }
  ];

  const possessionData = [
    { name: 'Ev Sahibi', value: stats.possession.home, color: '#3B82F6' },
    { name: 'Misafir', value: stats.possession.away, color: '#EF4444' }
  ];

  const StatBar = ({ label, homeValue, awayValue, homeTeam = "Ev Sahibi", awayTeam = "Misafir" }) => {
    const total = homeValue + awayValue;
    const homePercentage = total > 0 ? (homeValue / total) * 100 : 50;
    const awayPercentage = total > 0 ? (awayValue / total) * 100 : 50;

    return (
      <div className="space-y-2">
        <div className="flex justify-between items-center">
          <span className="text-sm font-medium">{label}</span>
          <div className="flex space-x-4">
            <span className="text-sm font-bold">{homeValue}</span>
            <span className="text-sm font-bold">{awayValue}</span>
          </div>
        </div>
        
        <div className="flex items-center">
          <div className="flex-1 bg-gray-200 rounded-full h-2 overflow-hidden">
            <div className="flex h-full">
              <motion.div
                initial={{ width: 0 }}
                animate={{ width: `${homePercentage}%` }}
                transition={{ duration: 1, ease: "easeOut" }}
                className="bg-blue-500"
              />
              <motion.div
                initial={{ width: 0 }}
                animate={{ width: `${awayPercentage}%` }}
                transition={{ duration: 1, ease: "easeOut", delay: 0.2 }}
                className="bg-red-500"
              />
            </div>
          </div>
        </div>
      </div>
    );
  };

  return (
    <div className="space-y-6">
      <h3 className="text-lg font-semibold">Maç İstatistikleri</h3>

      {/* Possession Chart */}
      <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div className="bg-gray-50 p-4 rounded-lg">
          <h4 className="font-medium mb-4">Top Hakimiyeti</h4>
          <div className="h-48">
            <ResponsiveContainer width="100%" height="100%">
              <PieChart>
                <Pie
                  data={possessionData}
                  cx="50%"
                  cy="50%"
                  innerRadius={40}
                  outerRadius={80}
                  paddingAngle={5}
                  dataKey="value"
                  label={({ name, value }) => `${name}: %${value}`}
                >
                  {possessionData.map((entry, index) => (
                    <Cell key={`cell-${index}`} fill={entry.color} />
                  ))}
                </Pie>
                <Tooltip />
              </PieChart>
            </ResponsiveContainer>
          </div>
        </div>

        <div className="bg-gray-50 p-4 rounded-lg">
          <h4 className="font-medium mb-4">İstatistik Karşılaştırması</h4>
          <div className="h-48">
            <ResponsiveContainer width="100%" height="100%">
              <BarChart data={chartData}>
                <CartesianGrid strokeDasharray="3 3" />
                <XAxis dataKey="name" />
                <YAxis />
                <Tooltip />
                <Bar dataKey="home" fill="#3B82F6" name="Ev Sahibi" />
                <Bar dataKey="away" fill="#EF4444" name="Misafir" />
              </BarChart>
            </ResponsiveContainer>
          </div>
        </div>
      </div>

      {/* Detailed Stats */}
      <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div className="space-y-4">
          <h4 className="font-medium">Saldırı İstatistikleri</h4>
          <div className="space-y-4">
            <StatBar
              label="Şutlar"
              homeValue={stats.shots.home}
              awayValue={stats.shots.away}
            />
            <StatBar
              label="Kornerler"
              homeValue={stats.corners.home}
              awayValue={stats.corners.away}
            />
            <StatBar
              label="Top Hakimiyeti (%)"
              homeValue={stats.possession.home}
              awayValue={stats.possession.away}
            />
          </div>
        </div>

        <div className="space-y-4">
          <h4 className="font-medium">Defans İstatistikleri</h4>
          <div className="space-y-4">
            <StatBar
              label="Fauller"
              homeValue={stats.fouls.home}
              awayValue={stats.fouls.away}
            />
            <StatBar
              label="Ofsaytlar"
              homeValue={stats.offsides?.home || 0}
              awayValue={stats.offsides?.away || 0}
            />
            <StatBar
              label="Kartlar"
              homeValue={stats.cards?.home || 0}
              awayValue={stats.cards?.away || 0}
            />
          </div>
        </div>
      </div>

      {/* Quick Stats Summary */}
      <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
        <motion.div
          whileHover={{ scale: 1.05 }}
          className="bg-gradient-to-br from-blue-500 to-blue-600 p-4 rounded-lg text-white text-center"
        >
          <div className="text-2xl font-bold">{stats.shots.home + stats.shots.away}</div>
          <div className="text-sm opacity-90">Toplam Şut</div>
        </motion.div>

        <motion.div
          whileHover={{ scale: 1.05 }}
          className="bg-gradient-to-br from-green-500 to-green-600 p-4 rounded-lg text-white text-center"
        >
          <div className="text-2xl font-bold">{stats.corners.home + stats.corners.away}</div>
          <div className="text-sm opacity-90">Toplam Korner</div>
        </motion.div>

        <motion.div
          whileHover={{ scale: 1.05 }}
          className="bg-gradient-to-br from-yellow-500 to-yellow-600 p-4 rounded-lg text-white text-center"
        >
          <div className="text-2xl font-bold">{stats.fouls.home + stats.fouls.away}</div>
          <div className="text-sm opacity-90">Toplam Faul</div>
        </motion.div>

        <motion.div
          whileHover={{ scale: 1.05 }}
          className="bg-gradient-to-br from-purple-500 to-purple-600 p-4 rounded-lg text-white text-center"
        >
          <div className="text-2xl font-bold">
            {Math.abs(stats.possession.home - stats.possession.away)}%
          </div>
          <div className="text-sm opacity-90">Hakimiyet Farkı</div>
        </motion.div>
      </div>

      {/* Performance Indicators */}
      <div className="bg-gray-50 p-4 rounded-lg">
        <h4 className="font-medium mb-3">Performans Göstergeleri</h4>
        <div className="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
          <div>
            <div className="text-sm text-gray-600">Saldırı Gücü</div>
            <div className="font-bold text-lg">
              {stats.shots.home > stats.shots.away ? 'Ev Sahibi' : 
               stats.shots.away > stats.shots.home ? 'Misafir' : 'Eşit'}
            </div>
          </div>
          
          <div>
            <div className="text-sm text-gray-600">Oyun Kontrolü</div>
            <div className="font-bold text-lg">
              {stats.possession.home > 55 ? 'Ev Sahibi' : 
               stats.possession.away > 55 ? 'Misafir' : 'Dengeli'}
            </div>
          </div>
          
          <div>
            <div className="text-sm text-gray-600">Disiplin</div>
            <div className="font-bold text-lg">
              {stats.fouls.home < stats.fouls.away ? 'Ev Sahibi' : 
               stats.fouls.away < stats.fouls.home ? 'Misafir' : 'Eşit'}
            </div>
          </div>
          
          <div>
            <div className="text-sm text-gray-600">Set Piece</div>
            <div className="font-bold text-lg">
              {stats.corners.home > stats.corners.away ? 'Ev Sahibi' : 
               stats.corners.away > stats.corners.home ? 'Misafir' : 'Eşit'}
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default MatchStats;