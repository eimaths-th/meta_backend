<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Ava - Jarvis Azure TTS</title>
</head>
<body>
  <h1>Ava - Jarvis Demo</h1>
  <button onclick="speakJarvis()">▶ ฟังเสียง Ava</button>

  <script>
    async function speakJarvis() {
      const tokenMeta = document.querySelector('meta[name="csrf-token"]');
      if (!tokenMeta) {
        console.error('ไม่พบ CSRF token!');
        return;
      }
      const token = tokenMeta.getAttribute('content');

      const ssmlText = `
          <speak version='1.0' xml:lang='th-TH'>
              <voice xml:lang='th-TH' xml:gender='Female' name='th-TH-NiwatNeural'>
                  สวัสดีครับท่าน
                  <lang xml:lang='en-US'>this is Ava speaking</lang>
                  พร้อมปฏิบัติงานแล้ว
              </voice>
          </speak>`;

      try {
        const response = await fetch('{{
      route(
        'generate.tts',
      )
    }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
          },
          body: JSON.stringify({ input: { ssml: ssmlText } })
        });

        if (!response.ok) throw new Error('ไม่สามารถรับเสียงจาก server ได้');

        const audioBlob = await response.blob();
        const audioUrl = URL.createObjectURL(audioBlob);
        const audio = new Audio(audioUrl);
        audio.play();

        console.log('[Ava System] กำลังประมวลผลคำสั่ง...');
      } catch (err) {
        console.error('[Ava System] เกิดข้อผิดพลาด:', err.message);
      }
    }
  </script>
</body>
</html>
