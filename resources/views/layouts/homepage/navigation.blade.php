  <!-- Preloader -->
  <div class="spinner-wrapper">
      <div class="spinner">
          <div class="bounce1"></div>
          <div class="bounce2"></div>
          <div class="bounce3"></div>
      </div>
  </div>
  <!-- end of preloader -->
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
      <!-- Text Logo - Use this if you don't have a graphic logo -->
      <!-- <a class="navbar-brand logo-text page-scroll" href="index.html">Evolo</a> -->

      <!-- Image Logo -->
      {{-- <a class="navbar-brand logo-image" href="index.html"><img src={{asset("images/logo.svg")}} alt="alternative"></a> logo --}}

      <!-- Mobile Menu Toggle Button -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
          aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-awesome fas fa-bars"></span>
          <span class="navbar-toggler-awesome fas fa-times"></span>
      </button>
      <!-- end of mobile menu toggle button -->

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
          <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                  <a class="nav-link page-scroll" href="#header">Home <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                  <a class="nav-link page-scroll" href="#services">Services</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link page-scroll" href="#pricing">Pricing</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link page-scroll" href="#request">Request</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link page-scroll" data-toggle="modal" data-target="#loginModal">Login</a>
              </li>

              <!-- Dropdown Menu -->
              <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle page-scroll" href="#about" id="navbarDropdown" role="button"
                      aria-haspopup="true" aria-expanded="false">About</a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="terms-conditions.html"><span class="item-text">Terms
                              Conditions</span></a>
                      <div class="dropdown-items-divide-hr"></div>
                      <a class="dropdown-item" href="privacy-policy.html"><span class="item-text">Privacy
                              Policy</span></a>
                  </div>
              </li>
              <!-- end of dropdown menu -->

              <li class="nav-item">
                  <a class="nav-link page-scroll" href="#contact">Contact</a>
              </li>
          </ul>
      </div>
  </nav> <!-- end of navbar -->
  <!-- end of navigation -->



  <!-- Popup -->
  <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
              <div class="modal-header border-bottom-0">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                  </button>
              </div>
              <div class="modal-body">
                  <div class="form-title text-center">
                      <h4>Login</h4>
                  </div>
                  <div class="d-flex flex-column text-center">

                     <form method="POST" action="{{ route('login') }}">
                         @csrf
                          <div class="form-group">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                          </div>
                          <div class="form-group">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                          </div>
                          <button type="submit" class="btn btn-info btn-block btn-round">Login</button>
                      <div class="text-center text-muted delimiter">or use a social network</div>
                      <div class="d-flex justify-content-center social-buttons">
                          <button type="button" class="btn btn-secondary btn-round" data-toggle="tooltip"
                              data-placement="top" title="google">
                              <a href="{{ url('login/google') }}">
                                <i class="fab fa-google"></i>
                            </a>

                          </button>
                          <button type="button" class="btn btn-secondary btn-round" data-toggle="tooltip"
                              data-placement="top" title="Facebook">
                              <i class="fab fa-facebook"></i>
                          </button>
                          <button type="button" class="btn btn-secondary btn-round" data-toggle="tooltip"
                              data-placement="top" title="Linkedin">
                              <i class="fab fa-linkedin"></i>
                          </button>
                      </div>
                    </form>
                  </div>
              </div>
              <div class="modal-footer d-flex justify-content-center">
                  <div class="signup-section">Not a member yet? <a href="register" class="text-info"> Sign Up</a>.
                  </div>
              </div>
          </div>
      </div>
    </div>



      <style>
          .container {
              padding: 2rem 0rem;
          }

          @media (min-width: 576px) {
              .modal-dialog {
                  max-width: 400px;
              }

              .modal-dialog .modal-content {
                  padding: 1rem;
              }
          }

          .modal-header .close {
              margin-top: -1.5rem;
          }

          .form-title {
              margin: -2rem 0rem 2rem;
          }

          .btn-round {
              border-radius: 3rem;
          }

          .delimiter {
              padding: 1rem;
          }

          .social-buttons .btn {
              margin: 0 0.5rem 1rem;
          }

          .signup-section {
              padding: 0.3rem 0rem;
          }
      </style>




      <link rel='stylesheet'
          href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css'>

      <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.3.1/css/all.css'>

      <!-- jQuery -->
      <script src='https://code.jquery.com/jquery-3.3.1.slim.min.js'></script>
      <!-- Popper JS -->
      <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js'></script>
      <!-- Bootstrap JS -->
      <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js'></script>

      <script>
        $(document).ready(function() {
          $('#close-popup, .modal-backdrop').click(function() {
            $('#loginModal').modal('hide');
          });

          // Mở modal khi bạn muốn
          $('#open-popup-button').click(function() {
            $('#loginModal').modal('show');
          });
        });
      </script>

