(() => {
  function initialize() {
    const editor = document.getElementById('banner-editor');
    if (!editor) return;

    const controls = {
      fit: document.getElementById('banner-fit'),
      desktop_height: document.getElementById('banner-desktop-height'),
      mobile_height: document.getElementById('banner-mobile-height'),
      position_x: document.getElementById('banner-position-x'),
      position_y: document.getElementById('banner-position-y')
    };
    const autoMax = JSON.parse(editor.dataset.autoMax);
    const previews = Array.from(editor.querySelectorAll('[data-preview]'), panel => ({
      device: panel.dataset.preview,
      width: Number(panel.dataset.width),
      frame: panel.querySelector('.banner-editor-frame'),
      image: panel.querySelector('img'),
      empty: panel.querySelector('.banner-editor-frame span')
    }));
    const fileInput = document.getElementById('brand');
    const fileError = document.getElementById('banner-file-error');
    const originalSource = previews[0].image.getAttribute('src') || '';
    const buttons = editor.querySelectorAll('[data-banner-device]');
    const manualControls = document.getElementById('banner-manual-controls');
    let objectUrl = null;

    function number(key) {
      const input = controls[key];
      const value = Number(input.value);
      return Math.max(Number(input.min), Math.min(Number(input.max), Number.isFinite(value) ? value : Number(input.defaultValue)));
    }

    function render() {
      const fit = ['auto', 'contain', 'cover'].includes(controls.fit.value) ? controls.fit.value : 'auto';
      const automatic = fit === 'auto';
      previews.forEach(({ device, width, frame, image }) => {
        const ratio = image.naturalWidth > 0 ? image.naturalHeight / image.naturalWidth : 0.25;
        const height = automatic ? Math.min(width * ratio, autoMax[device]) : number(device + '_height');
        frame.style.aspectRatio = width + ' / ' + height;
        image.style.objectFit = automatic ? 'contain' : fit;
        image.style.objectPosition = automatic ? '50% 50%' : number('position_x') + '% ' + number('position_y') + '%';
      });
      manualControls.hidden = automatic;
      manualControls.disabled = automatic;
      document.getElementById('banner-reset').hidden = automatic;
      document.getElementById('banner-position-controls').hidden = fit !== 'cover';
      document.getElementById('banner-position-x-value').textContent = number('position_x') + '%';
      document.getElementById('banner-position-y-value').textContent = number('position_y') + '%';
      document.getElementById('banner-mode-summary').textContent = automatic ?
        'อัตโนมัติ · แสดงภาพครบ ไม่ตัดขอบ' : fit === 'cover' ?
          'ครอปเต็มกรอบ · อาจตัดขอบภาพ' : 'แสดงภาพครบในกรอบที่กำหนด';
    }

    Object.values(controls).forEach(input => {
      input.addEventListener('input', render);
      input.addEventListener('change', render);
    });
    buttons.forEach(button => button.addEventListener('click', () => {
      editor.dataset.previewDevice = button.dataset.bannerDevice;
      buttons.forEach(item => item.setAttribute('aria-pressed', String(item === button)));
    }));
    document.getElementById('banner-reset').addEventListener('click', () => {
      controls.fit.value = 'auto';
      document.getElementById('banner-advanced').open = false;
      render();
    });

    function refreshFilePreview() {
      const file = fileInput.files[0];
      const validType = !file || ['image/jpeg', 'image/png', 'image/gif'].includes(file.type);
      const message = !validType ? 'กรุณาเลือกรูป JPG, PNG หรือ GIF' :
        file && file.size > 5 * 1024 * 1024 ? 'รูปแบนเนอร์ต้องมีขนาดไม่เกิน 5 MB' : '';
      fileError.textContent = message;
      fileError.hidden = !message;
      fileInput.setCustomValidity(message);
      if (message) return;
      if (objectUrl) URL.revokeObjectURL(objectUrl);
      objectUrl = file ? URL.createObjectURL(file) : null;
      const source = objectUrl || originalSource;
      previews.forEach(({ image, empty }) => {
        if (source) image.src = source;
        else image.removeAttribute('src');
        image.hidden = !source;
        empty.hidden = Boolean(source);
      });
      render();
    }
    fileInput.addEventListener('change', refreshFilePreview);
    const form = editor.closest('form');
    if (form) form.addEventListener('reset', () => {
      setTimeout(() => {
        document.getElementById('banner-advanced').open = false;
        refreshFilePreview();
      }, 0);
    });
    previews.forEach(({ image }) => {
      image.addEventListener('load', render);
      image.addEventListener('error', () => {
        fileError.textContent = 'ไม่สามารถแสดงรูปตัวอย่างได้ กรุณาตรวจสอบไฟล์รูป';
        fileError.hidden = false;
      });
    });
    window.addEventListener('pagehide', () => { if (objectUrl) URL.revokeObjectURL(objectUrl); });
    render();
  }
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', initialize);
  else initialize();
})();
