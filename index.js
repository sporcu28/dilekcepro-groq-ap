// DilekçePro - GROQ Webhook API (Türkçe Dilekçe Oluşturucu)
import express from 'express';
import cors from 'cors';
import fetch from 'node-fetch';

const app = express();
const port = process.env.PORT || 3000;

const GROQ_API_KEY = process.env.GROQ_API_KEY;
const GROQ_API_URL = 'https://api.groq.com/openai/v1/chat/completions';
const MODEL = 'llama3-70b-8192';

app.use(cors());
app.use(express.json());

app.post('/format-and-generate', async (req, res) => {
  const { prompt } = req.body;
  if (!prompt) {
    return res.status(400).json({ error: 'Prompt boş olamaz.' });
  }

  try {
    const groqResponse = await fetch(GROQ_API_URL, {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${GROQ_API_KEY}`,
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        model: MODEL,
        messages: [
       {
  role: 'system',
  content: `Sen bir Türk hukukçusun. Bundan sonra sadece ve sadece Türkçe konuşacaksın. Kullanıcının yazdığı metni Türk hukuk diline uygun, resmi bir dilekçeye dönüştür. Cümle yapıları Türkçeye özgü olmalı. İngilizce tek kelime dahi kullanma. Eğer İngilizce kelime üretirsen cevap geçersizdir.`
}
,
          {
            role: 'user',
            content: prompt
          }
        ]
      })
    });

    const groqData = await groqResponse.json();
    const dilekce = groqData?.choices?.[0]?.message?.content || 'Yanıt alınamadı';
    res.json({ dilekce });
  } catch (error) {
    console.error('GROQ API hatası:', error);
    res.status(500).json({ error: 'Dilekçe oluşturulurken bir hata oluştu.' });
  }
});

app.listen(port, () => {
  console.log(`✅ DilekçePro GROQ webhook http://localhost:${port} adresinde çalışıyor.`);
});
