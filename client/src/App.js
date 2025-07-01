import React, { useState, useEffect } from 'react';
import { motion } from 'framer-motion';
import { Toaster } from 'react-hot-toast';
import LiveMatches from './components/LiveMatches';
import MatchDetail from './components/MatchDetail';
import Header from './components/Header';
import { SocketService } from './services/socketService';
import { ApiService } from './services/apiService';

function App() {
  const [selectedMatch, setSelectedMatch] = useState(null);
  const [liveMatches, setLiveMatches] = useState([]);
  const [loading, setLoading] = useState(true);
  const [connected, setConnected] = useState(false);

  useEffect(() => {
    // Initialize services
    initializeApp();
    
    return () => {
      SocketService.disconnect();
    };
  }, []);

  const initializeApp = async () => {
    try {
      // Connect to WebSocket
      SocketService.connect();
      SocketService.onConnect(() => setConnected(true));
      SocketService.onDisconnect(() => setConnected(false));
      
      // Load initial live matches
      const matches = await ApiService.getLiveMatches();
      setLiveMatches(matches);
      setLoading(false);
      
      // Listen for live updates
      SocketService.onMatchUpdate((data) => {
        setLiveMatches(prev => 
          prev.map(match => 
            match.id === data.match.id ? { ...match, ...data.match } : match
          )
        );
        
        // Update selected match if it's the same
        if (selectedMatch && selectedMatch.id === data.match.id) {
          setSelectedMatch({ ...selectedMatch, ...data.match });
        }
      });
      
    } catch (error) {
      console.error('Error initializing app:', error);
      setLoading(false);
    }
  };

  const handleMatchSelect = async (match) => {
    try {
      setLoading(true);
      const matchDetails = await ApiService.getMatchDetails(match.id);
      setSelectedMatch(matchDetails);
      
      // Subscribe to this match's updates
      SocketService.subscribeToMatch(match.id);
      setLoading(false);
    } catch (error) {
      console.error('Error loading match details:', error);
      setLoading(false);
    }
  };

  const handleBackToMatches = () => {
    if (selectedMatch) {
      SocketService.unsubscribeFromMatch(selectedMatch.id);
    }
    setSelectedMatch(null);
  };

  return (
    <div className="min-h-screen">
      <Toaster 
        position="top-right"
        toastOptions={{
          duration: 4000,
          style: {
            background: 'rgba(255, 255, 255, 0.95)',
            backdropFilter: 'blur(10px)',
            border: '1px solid rgba(255, 255, 255, 0.18)',
          },
        }}
      />
      
      <Header connected={connected} />
      
      <main className="container py-6">
        {loading ? (
          <div className="flex items-center justify-center min-h-[400px]">
            <motion.div
              animate={{ rotate: 360 }}
              transition={{ duration: 1, repeat: Infinity, ease: "linear" }}
              className="w-12 h-12 border-4 border-white border-t-transparent rounded-full"
            />
          </div>
        ) : selectedMatch ? (
          <MatchDetail 
            match={selectedMatch} 
            onBack={handleBackToMatches}
          />
        ) : (
          <motion.div
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            transition={{ duration: 0.6 }}
          >
            <div className="text-center mb-8">
              <h1 className="text-4xl font-bold text-white mb-4">
                🤖 AI Sports Predictor
              </h1>
              <p className="text-lg text-white/80 max-w-2xl mx-auto">
                Yapay zeka destekli canlı maç analiz sistemi. Gerçek zamanlı tahminler, 
                detaylı analizler ve %100 doğruluk hedefi.
              </p>
            </div>
            
            <LiveMatches 
              matches={liveMatches}
              onMatchSelect={handleMatchSelect}
            />
            
            {liveMatches.length === 0 && (
              <motion.div
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                className="text-center py-12"
              >
                <div className="card max-w-md mx-auto">
                  <h3 className="text-xl font-semibold mb-2">
                    Şu anda canlı maç bulunmuyor
                  </h3>
                  <p className="text-gray-600">
                    Canlı maçlar başladığında burada görünecek ve AI tahminleri aktif olacak.
                  </p>
                </div>
              </motion.div>
            )}
          </motion.div>
        )}
      </main>
    </div>
  );
}

export default App;