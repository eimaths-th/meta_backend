@php
  $bannerSettings = $data->banner_display;
  $bannerAuto = $bannerSettings['fit'] === 'auto';
  $bannerSource = !empty($data->brand) ? asset('form_manage/brand/' . $data->brand) : '';
  $bannerPublicSlug = $data->slug ?: $data->form_route;
@endphp
<fieldset id="banner-editor" class="banner-editor" data-auto-max="{{ json_encode(\App\Support\FormBannerSettings::AUTO_MAX_HEIGHTS) }}" data-preview-device="mobile">
  <legend>แบนเนอร์หน้าลงทะเบียน</legend>
  <p class="banner-editor-intro">เลือกรูปครั้งเดียว ระบบจัดให้พอดีทั้งคอมพิวเตอร์และมือถือ</p>

  <label for="brand">รูปแบนเนอร์ (Brand Image)</label>
  <input type="file" name="brand" id="brand" class="form-control" accept="image/jpeg,image/png,image/gif" aria-describedby="banner-file-help banner-file-error" />
  @if (!empty($data->brand))
    <input type="hidden" name="oldBrand" id="oldBrand" value="{{ $data->brand }}" />
  @endif
  <p id="banner-file-help" class="banner-editor-help">JPG, PNG หรือ GIF ไม่เกิน 5 MB · ใช้รูปแนวนอนสำหรับแบนเนอร์ หรือรูปแนวตั้งเพื่อแสดงโปสเตอร์ครบทั้งภาพ</p>
  <p id="banner-file-error" class="banner-editor-error" role="alert" hidden></p>

  <div class="banner-editor-status">
    <p id="banner-mode-summary" aria-live="polite">{{ $bannerAuto ? 'อัตโนมัติ · แสดงภาพครบ ไม่ตัดขอบ' : ($bannerSettings['fit'] === 'cover' ? 'ครอปเต็มกรอบ · อาจตัดขอบภาพ' : 'แสดงภาพครบในกรอบที่กำหนด') }}</p>
    <button type="button" id="banner-reset" class="banner-editor-reset" @if ($bannerAuto) hidden @endif>ใช้แบบอัตโนมัติ</button>
  </div>
  <div class="banner-editor-toolbar" role="group" aria-label="ขนาดหน้าจอสำหรับดูตัวอย่างแบนเนอร์">
    <button type="button" data-banner-device="desktop" aria-pressed="false">คอมพิวเตอร์</button>
    <button type="button" data-banner-device="mobile" aria-pressed="true">มือถือ</button>
  </div>
  <div class="banner-editor-previews">
    @foreach (['desktop' => ['label' => 'คอมพิวเตอร์', 'width' => 950], 'mobile' => ['label' => 'มือถือ', 'width' => 356]] as $device => $preview)
      <figure class="banner-editor-preview" data-preview="{{ $device }}" data-width="{{ $preview['width'] }}">
        <figcaption>{{ $preview['label'] }} <span>ตัวอย่างย่อตามสัดส่วน</span></figcaption>
        <div class="banner-editor-stage">
          <div class="banner-editor-frame" style="aspect-ratio: {{ $preview['width'] }} / {{ $bannerSettings[$device . '_height'] }}">
            <img @if ($bannerSource !== '') src="{{ $bannerSource }}" @endif alt="ตัวอย่างแบนเนอร์บน{{ $preview['label'] }}" style="object-fit: {{ $bannerAuto ? 'contain' : $bannerSettings['fit'] }}; object-position: {{ $bannerAuto ? '50% 50%' : $bannerSettings['position_x'] . '% ' . $bannerSettings['position_y'] . '%' }}" @if ($bannerSource === '') hidden @endif />
            <span @if ($bannerSource !== '') hidden @endif>เลือกรูปเพื่อดูตัวอย่าง</span>
          </div>
        </div>
      </figure>
    @endforeach
  </div>

  <details id="banner-advanced" class="banner-editor-advanced">
    <summary>ตั้งค่าขั้นสูง</summary>
    <div class="banner-editor-advanced-content">
      <label for="banner-fit">การแสดงภาพ</label>
      <select id="banner-fit" name="banner_settings[fit]" class="form-control">
        <option value="auto" @selected($bannerAuto)>อัตโนมัติ — แสดงภาพครบ (แนะนำ)</option>
        <option value="contain" @selected($bannerSettings['fit'] === 'contain')>แสดงภาพครบในกรอบที่กำหนด</option>
        <option value="cover" @selected($bannerSettings['fit'] === 'cover')>ครอปภาพให้เต็มกรอบ</option>
      </select>
      <p class="banner-editor-help">โหมดอัตโนมัติปรับความสูงตามสัดส่วนรูป ภาพแนวตั้งจะจำกัดความสูงและอาจมีพื้นที่ว่างด้านข้าง</p>
      <fieldset id="banner-manual-controls" @if ($bannerAuto) hidden disabled @endif>
        <legend class="visually-hidden">กำหนดขนาดกรอบด้วยตนเอง</legend>
        <div class="banner-editor-heights">
          <div>
            <label for="banner-desktop-height">ความสูงบนคอมฯ (px)</label>
            <input type="number" id="banner-desktop-height" name="banner_settings[desktop_height]" class="form-control" min="120" max="480" step="1" required value="{{ $bannerSettings['desktop_height'] }}" />
            <small>120–480 พิกเซล</small>
          </div>
          <div>
            <label for="banner-mobile-height">ความสูงบนมือถือ (px)</label>
            <input type="number" id="banner-mobile-height" name="banner_settings[mobile_height]" class="form-control" min="100" max="320" step="1" required value="{{ $bannerSettings['mobile_height'] }}" />
            <small>100–320 พิกเซล</small>
          </div>
        </div>
        <div id="banner-position-controls" @if ($bannerSettings['fit'] !== 'cover') hidden @endif>
          <label for="banner-position-x">ตำแหน่งซ้าย–ขวา <output id="banner-position-x-value" for="banner-position-x">{{ $bannerSettings['position_x'] }}%</output></label>
          <input type="range" id="banner-position-x" name="banner_settings[position_x]" min="0" max="100" step="1" value="{{ $bannerSettings['position_x'] }}" />
          <label for="banner-position-y">ตำแหน่งบน–ล่าง <output id="banner-position-y-value" for="banner-position-y">{{ $bannerSettings['position_y'] }}%</output></label>
          <input type="range" id="banner-position-y" name="banner_settings[position_y]" min="0" max="100" step="1" value="{{ $bannerSettings['position_y'] }}" />
          <p class="banner-editor-help">เลื่อนให้โลโก้และข้อความสำคัญอยู่ในกรอบ แล้วตรวจตัวอย่างทั้งสองขนาด</p>
        </div>
      </fieldset>
    </div>
  </details>
  <div class="banner-editor-footer">
    <p class="banner-editor-help">กดบันทึกฟอร์มเพื่อใช้รูปและการแสดงผลนี้กับหน้าลูกค้า</p>
    @if ($bannerPublicSlug)
      <a href="{{ route('form.show', ['slug' => $bannerPublicSlug]) }}" target="_blank" rel="noopener noreferrer">ดูหน้าลงทะเบียนจริง ↗ <small>(ข้อมูลที่บันทึกแล้ว)</small></a>
    @endif
  </div>
</fieldset>
