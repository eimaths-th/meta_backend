<div align="center" class="alignment" style="line-height: 10px">
  <!-- <a href="https://www.example.com" style="outline:none" tabindex="-1" target="_blank"><img alt="your-logo" class="big" src="images/Your-logo.png" style="display: block; height: auto; border: 0; width: 304px; max-width: 100%;" title="your-logo" width="304"/></a> -->
  <img
    src="{{ asset('images/Logo_Mata-knowledfe_final_PNG.png') }}"
    alt="..."
    srcset=""
    style="height: 200px"
  />
</div>
<h1 align="center">Forget Password Email</h1>
<div align="center">
  You can reset password from bellow link:
  <a href="{{ route('reset.password.get', $token) }}">Reset Password</a>
</div>
