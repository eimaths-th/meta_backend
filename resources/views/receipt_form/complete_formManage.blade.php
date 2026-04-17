@extends ('layouts.form')

@section ('style')
  <style>
    :root {
      --primary-orange: #ff6b35;
      --secondary-orange: #ff8c42;
      --accent-orange: #ffa500;
      --dark-orange: #d84315;
      --light-orange: #ffe0b2;
      --success-green: #51cf66;
    }

    body {
      background: linear-gradient(
        135deg,
        #ffb555 0%,
        #ffa742 50%,
        #ffa500 100%
      ) !important;
      min-height: 100vh;
      font-family: 'Sarabun', 'Kanit', sans-serif;
    }

    main {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px 0;
    }

    .success-container {
      animation: fadeInUp 0.8s ease-out;
    }
    @keyframes
    fadeInUp {
         from {
           opacity: 0;
           transform: translateY(30px);
         }
         to {
           opacity: 1;
           transform: translateY(0);
         }
       }

       .success-card {
         background: white;
         border-radius: 25px;
         box-shadow: 0 10px 30px rgba(255, 107, 53, 0.3);
         overflow: hidden;
         border: none;
       }

       .success-header {
         background: linear-gradient(135deg, #ff6b35 0%, #ff8c42 100%);
         padding: 40px 20px;
         position: relative;
         overflow: hidden;
       }

       .success-header::before {
         content: '';
         position: absolute;
         top: -50%;
         left: -50%;
         width: 200%;
         height: 200%;
         background: radial-gradient(
           circle,
           rgba(255, 255, 255, 0.1) 0%,
           transparent 70%
         );
         animation: pulse 3s ease-in-out infinite;
       }
    @keyframes
    pulse {
         0%,
         100% {
           transform: scale(1);
           opacity: 0.5;
         }
         50% {
           transform: scale(1.1);
           opacity: 0.8;
         }
       }

       .success-icon-wrapper {
         position: relative;
         z-index: 1;
         animation: bounceIn 1s ease-out;
       }
    @keyframes
    bounceIn {
         0% {
           transform: scale(0);
           opacity: 0;
         }
         50% {
           transform: scale(1.1);
         }
         100% {
           transform: scale(1);
           opacity: 1;
         }
       }

       .success-icon {
         width: 120px;
         height: 120px;
         background: white;
         border-radius: 50%;
         display: flex;
         align-items: center;
         justify-content: center;
         margin: 0 auto;
         box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
       }

       .success-icon i {
         font-size: 60px;
         color: #28a745;
         animation: checkmark 0.6s ease-in-out 0.3s both;
       }
    @keyframes
    checkmark {
         0% {
           transform: scale(0) rotate(-45deg);
         }
         50% {
           transform: scale(1.2) rotate(0deg);
         }
         100% {
           transform: scale(1) rotate(0deg);
         }
       }

       .success-title {
         color: white;
         font-size: 2.5rem;
         font-weight: 700;
         margin-top: 20px;
         margin-bottom: 10px;
         text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
         animation: fadeIn 1s ease-out 0.3s both;
       }
    @keyframes
    fadeIn {
         from {
           opacity: 0;
         }
         to {
           opacity: 1;
         }
       }

       .success-subtitle {
         color: rgba(255, 255, 255, 0.95);
         font-size: 1.1rem;
         font-weight: 500;
         animation: fadeIn 1s ease-out 0.5s both;
       }

       .success-body {
         padding: 40px 30px;
       }

       .info-box {
         background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
         border-radius: 15px;
         padding: 25px;
         margin-bottom: 30px;
         border-left: 5px solid #667eea;
         animation: slideInLeft 0.8s ease-out 0.6s both;
       }
    @keyframes
    slideInLeft {
         from {
           opacity: 0;
           transform: translateX(-30px);
         }
         to {
           opacity: 1;
           transform: translateX(0);
         }
       }

       .info-box i {
         font-size: 24px;
         color: #667eea;
         margin-right: 15px;
       }

       .info-box p {
         margin: 0;
         color: #2c3e50;
         font-size: 1rem;
         line-height: 1.6;
       }

       .success-footer {
         background: #f8f9fa;
         padding: 30px;
         border-top: 1px solid #e9ecef;
       }

       .btn-back {
         background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
         color: white;
         border: none;
         padding: 15px 40px;
         border-radius: 50px;
         font-size: 1.1rem;
         font-weight: 600;
         text-transform: uppercase;
         letter-spacing: 1px;
         box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
         transition: all 0.3s ease;
         animation: slideInUp 0.8s ease-out 0.8s both;
       }
    @keyframes
    slideInUp {
         from {
           opacity: 0;
           transform: translateY(30px);
         }
         to {
           opacity: 1;
           transform: translateY(0);
         }
       }

       .btn-back:hover {
         transform: translateY(-3px);
         box-shadow: 0 15px 40px rgba(102, 126, 234, 0.6);
         color: white;
       }

       .btn-back i {
         margin-right: 10px;
         transition: transform 0.3s ease;
       }

       .btn-back:hover i {
         transform: translateX(-5px);
       }

       .decorative-dots {
         position: absolute;
         width: 100%;
         height: 100%;
         top: 0;
         left: 0;
         overflow: hidden;
         pointer-events: none;
       }

       .dot {
         position: absolute;
         width: 10px;
         height: 10px;
         background: rgba(255, 255, 255, 0.3);
         border-radius: 50%;
         animation: float 3s ease-in-out infinite;
       }

       .dot:nth-child(1) {
         top: 20%;
         left: 20%;
         animation-delay: 0s;
       }
       .dot:nth-child(2) {
         top: 60%;
         left: 80%;
         animation-delay: 0.5s;
       }
       .dot:nth-child(3) {
         top: 80%;
         left: 40%;
         animation-delay: 1s;
       }
       .dot:nth-child(4) {
         top: 40%;
         left: 70%;
         animation-delay: 1.5s;
       }
    @keyframes
    float {
         0%,
         100% {
           transform: translateY(0px);
         }
         50% {
           transform: translateY(-20px);
         }
       }

       /* Confetti effect */
       .confetti {
         position: fixed;
         width: 10px;
         height: 10px;
         background: #f0f;
         position: absolute;
         animation: confetti-fall 3s linear infinite;
       }
    @keyframes
    confetti-fall {
         to {
           transform: translateY(100vh) rotate(360deg);
         }
       }

       /* Responsive Adjustments */
    @media (max-width: 768px)
    {
         .success-title {
           font-size: 2rem;
         }

         .success-subtitle {
           font-size: 1rem;
         }

         .success-icon {
           width: 100px;
           height: 100px;
         }

         .success-icon i {
           font-size: 50px;
         }

         .success-body {
           padding: 30px 20px;
         }

         .btn-back {
           padding: 12px 30px;
           font-size: 1rem;
         }

         .info-box {
           padding: 20px;
         }
       }
    @media (max-width: 576px)
    {
         .success-title {
           font-size: 1.75rem;
         }

         .success-icon {
           width: 80px;
           height: 80px;
         }

         .success-icon i {
           font-size: 40px;
         }

         .btn-back {
           padding: 10px 25px;
           font-size: 0.95rem;
         }
       }
  </style>
@endsection

@section ('content')
  <div class="success-container container">
    <div class="row justify-content-center">
      <div class="col-md-10 col-lg-8">
        <div class="card success-card">
          <!-- Header with Icon -->
          <div class="success-header">
            <div class="decorative-dots">
              <div class="dot"></div>
              <div class="dot"></div>
              <div class="dot"></div>
              <div class="dot"></div>
            </div>
            <div class="success-icon-wrapper">
              <div class="success-icon">
                <i class="fas fa-check"></i>
              </div>
            </div>
            <h1 class="success-title">ขอบคุณ!</h1>
            <p class="success-subtitle">การส่งข้อมูลของคุณสำเร็จแล้ว</p>
          </div>

          <!-- Body -->
          <div class="success-body">
            @if ($sfield == 'test_field')
              <div class="info-box">
                <div class="d-flex align-items-center">
                  <i class="fas fa-envelope-open-text"></i>
                  <div>
                    <p>
                      <strong>กรุณารอรับ Email ตอบกลับภายใน 72 ชั่วโมง</strong>
                    </p>
                    <p
                      class="mb-0"
                      style="font-size: 0.9rem; color: #6c757d"
                    >เราจะส่งข้อมูลการยืนยันไปยังอีเมลของคุณในเร็วๆ นี้</p>
                  </div>
                </div>
              </div>
            @else
              <div class="info-box">
                <div class="d-flex align-items-center">
                  <i class="fas fa-check-circle"></i>
                  <div>
                    <p>
                      <strong>
                        Your submission has been received successfully!
                      </strong>
                    </p>
                    <p
                      class="mb-0"
                      style="font-size: 0.9rem; color: #6c757d"
                    >We will process your information and contact you soon.</p>
                  </div>
                </div>
              </div>
            @endif

            <div class="mt-4 text-center">
              <div
                style="
                  background: #fff3cd;
                  border-left: 4px solid #ffc107;
                  padding: 15px;
                  border-radius: 8px;
                  display: inline-block;
                  text-align: left;
                "
              >
                <i
                  class="fas fa-info-circle"
                  style="color: #ffc107; margin-right: 10px"
                ></i>
                <span style="color: #856404; font-size: 0.95rem">
                  หากมีข้อสงสัยเพิ่มเติม กรุณาติดต่อเรา
                </span>
              </div>
            </div>
          </div>

          <!-- Footer -->
          <div class="success-footer text-center">
            <a class="btn btn-back" href="{{ route('form.show', $sfield) }}">
              <i class="fas fa-arrow-left"></i>
              กลับไปที่ฟอร์ม
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
