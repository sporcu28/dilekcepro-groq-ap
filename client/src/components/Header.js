import React from 'react';
import { motion } from 'framer-motion';
import { Wifi, WifiOff, Brain, Activity } from 'lucide-react';

const Header = ({ connected }) => {
  return (
    <header className="bg-white/10 backdrop-blur-20 border-b border-white/20">
      <div className="container">
        <div className="flex items-center justify-between py-4">
          <motion.div 
            className="flex items-center space-x-3"
            initial={{ opacity: 0, x: -20 }}
            animate={{ opacity: 1, x: 0 }}
          >
            <div className="flex items-center space-x-2">
              <Brain className="w-8 h-8 text-white" />
              <span className="text-xl font-bold text-white">AI Sports Predictor</span>
            </div>
          </motion.div>
          
          <motion.div 
            className="flex items-center space-x-4"
            initial={{ opacity: 0, x: 20 }}
            animate={{ opacity: 1, x: 0 }}
          >
            <div className="flex items-center space-x-2">
              <Activity className="w-5 h-5 text-white/80" />
              <span className="text-sm text-white/80">Canlı Analiz</span>
            </div>
            
            <div className="flex items-center space-x-2">
              {connected ? (
                <motion.div
                  animate={{ scale: [1, 1.1, 1] }}
                  transition={{ repeat: Infinity, duration: 2 }}
                  className="flex items-center space-x-2 text-green-400"
                >
                  <Wifi className="w-5 h-5" />
                  <span className="text-sm">Bağlı</span>
                </motion.div>
              ) : (
                <div className="flex items-center space-x-2 text-red-400">
                  <WifiOff className="w-5 h-5" />
                  <span className="text-sm">Bağlantı Yok</span>
                </div>
              )}
            </div>
          </motion.div>
        </div>
      </div>
    </header>
  );
};

export default Header;