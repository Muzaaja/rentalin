@extends('layouts.app')

@section('content')

    <section class="hero">
      <div class="container"> <div class="hero-content">
          <h1 class="hero-title">Sewa Apa Saja,<br>Kapan Saja</h1>
          <p class="hero-desc">Temukan berbagai kebutuhan dalam<br>satu platform yang praktis dan aman.</p>
        </div>
      </div>
    </section>

    <section class="kategori-section">
      <div class="container kategori-container">
        
        <div class="kategori-item">
          <div class="icon-box"><img src="{{ asset('assets/img/kategori/icon-gadget@2x.png') }}" alt="Elektronik & Gadget"></div>
          <p>Elektronik &<br>Gadget</p>
        </div>
        
        <div class="kategori-item">
          <div class="icon-box"><img src="{{ asset('assets/img/kategori/icon-fashion@2x.png') }}" alt="Fashion & Aksesoris"></div>
          <p>Fashion &<br>Aksesoris</p>
        </div>
        
        <div class="kategori-item">
          <div class="icon-box"><img src="{{ asset('assets/img/kategori/icon-event@2x.png') }}" alt="Pesta & Event"></div>
          <p>Pesta &<br>Event</p>
        </div>
        
        <div class="kategori-item">
          <div class="icon-box"><img src="{{ asset('assets/img/kategori/icon-rumah-tangga@2x.png') }}" alt="Rumah Tangga"></div>
          <p>Rumah<br>Tangga</p>
        </div>
        
        <div class="kategori-item">
          <div class="icon-box"><img src="{{ asset('assets/img/kategori/icon-hobby@2x.png') }}" alt="Hobi & Olahraga"></div>
          <p>Hobi &<br>Olahraga</p>
        </div>

      </div>
    </section>

    <section class="produk-section">
      <div class="container">
        <h2 class="section-title">Produk Terpopuler</h2>
        
        <div class="produk-grid">
          
          <article class="card">
            <img src="{{ asset('assets/img/produk/Rectangle-19@2x.png') }}" alt="Iphone 17 Pro Max" class="card-img" loading="lazy">
            <div class="card-body">
              <h3 class="card-title">Iphone 17 Pro Max</h3>
              <p class="card-price">Rp.100.000 /hari</p>
              <div class="card-meta">
                <div class="card-rating">
                  <img src="{{ asset('assets/icons/star-rate-rounded.svg') }}" alt="Rating"> 5.0
                </div>
                <div class="card-renters">• 215 penyewa</div>
                <div class="card-location">Cibiru</div>
              </div>
            </div>
          </article>

          <article class="card">
            <img src="{{ asset('assets/img/produk/Rectangle-191@2x.png') }}" alt="Dji Osmo Pocket" class="card-img" loading="lazy">
            <div class="card-body">
              <h3 class="card-title">Dji Osmo pocket</h3>
              <p class="card-price">Rp.70.000 /hari</p>
              <div class="card-meta">
                <div class="card-rating">
                  <img src="{{ asset('assets/icons/star-rate-rounded.svg') }}" alt="Rating"> 5.0
                </div>
                <div class="card-renters">• 215 penyewa</div>
                <div class="card-location">Majalaya</div>
              </div>
            </div>
          </article>

          <article class="card">
            <img src="{{ asset('assets/img/produk/Rectangle-192@2x.png') }}" alt="Sepeda gunung oranye" class="card-img" loading="lazy">
            <div class="card-body">
              <h3 class="card-title">Sepeda gunung oranye</h3>
              <p class="card-price">Rp.70.000 /hari</p>
              <div class="card-meta">
                <div class="card-rating">
                  <img src="{{ asset('assets/icons/star-rate-rounded.svg') }}" alt="Rating"> 5.0
                </div>
                <div class="card-renters">• 45 penyewa</div>
                <div class="card-location">Cileunyi</div>
              </div>
            </div>
          </article>
          
          <article class="card">
            <img src="{{ asset('assets/img/produk/Rectangle-193@2x.png') }}" alt="Ipad gen 100 blue" class="card-img" loading="lazy">
            <div class="card-body">
              <h3 class="card-title">Ipad gen 100 blue</h3>
              <p class="card-price">Rp.50.000 /hari</p>
              <div class="card-meta">
                <div class="card-rating">
                  <img src="{{ asset('assets/icons/star-rate-rounded.svg') }}" alt="Rating"> 5.0
                </div>
                <div class="card-renters">• 175 penyewa</div>
                <div class="card-location">Cibiru</div>
              </div>
            </div>
          </article>
          
          <article class="card">
            <img src="{{ asset('assets/img/produk/Rectangle-194@2x.png') }}" alt="Air fryer meco" class="card-img" loading="lazy">
            <div class="card-body">
              <h3 class="card-title">Air fryer meco</h3>
              <p class="card-price">Rp.30.000 /hari</p>
              <div class="card-meta">
                <div class="card-rating">
                  <img src="{{ asset('assets/icons/star-rate-rounded.svg') }}" alt="Rating"> 5.0
                </div>
                <div class="card-renters">• 79 penyewa</div>
                <div class="card-location">Cicalengka</div>
              </div>
            </div>
          </article>
          
          <article class="card">
            <img src="{{ asset('assets/img/produk/Rectangle-195@2x.png') }}" alt="Paket mesin kopi" class="card-img" loading="lazy">
            <div class="card-body">
              <h3 class="card-title">Paket mesin kopi</h3>
              <p class="card-price">Rp.200.000 /hari</p>
              <div class="card-meta">
                <div class="card-rating">
                  <img src="{{ asset('assets/icons/star-rate-rounded.svg') }}" alt="Rating"> 5.0
                </div>
                <div class="card-renters">• 33 penyewa</div>
                <div class="card-location">Bojongsoang</div>
              </div>
            </div>
          </article>
          
          <article class="card">
            <img src="{{ asset('assets/img/produk/Rectangle-196@2x.png') }}" alt="Raket tennis keren" class="card-img" loading="lazy">
            <div class="card-body">
              <h3 class="card-title">Raket tennis keren</h3>
              <p class="card-price">Rp.20.000 /hari</p>
              <div class="card-meta">
                <div class="card-rating">
                  <img src="{{ asset('assets/icons/star-rate-rounded.svg') }}" alt="Rating"> 5.0
                </div>
                <div class="card-renters">• 27 penyewa</div>
                <div class="card-location">Baleendah</div>
              </div>
            </div>
          </article>
          
          <article class="card">
            <img src="{{ asset('assets/img/produk/Rectangle-197@2x.png') }}" alt="Kompor listrik portable" class="card-img" loading="lazy">
            <div class="card-body">
              <h3 class="card-title">Kompor listrik portable</h3>
              <p class="card-price">Rp.65.000 /hari</p>
              <div class="card-meta">
                <div class="card-rating">
                  <img src="{{ asset('assets/icons/star-rate-rounded.svg') }}" alt="Rating"> 5.0
                </div>
                <div class="card-renters">• 104 penyewa</div>
                <div class="card-location">Cinunuk</div>
              </div>
            </div>
          </article>
          
          <article class="card">
            <img src="{{ asset('assets/img/produk/Rectangle-198@2x.png') }}" alt="Iphone 16 Promax 1TB" class="card-img" loading="lazy">
            <div class="card-body">
              <h3 class="card-title">Iphone 16 Promax 1TB</h3>
              <p class="card-price">Rp.115.000 /hari</p>
              <div class="card-meta">
                <div class="card-rating">
                  <img src="{{ asset('assets/icons/star-rate-rounded.svg') }}" alt="Rating"> 5.0
                </div>
                <div class="card-renters">• 318 penyewa</div>
                <div class="card-location">Cileunyi</div>
              </div>
            </div>
          </article>
          
          <article class="card">
            <img src="{{ asset('assets/img/produk/Rectangle-199@2x.png') }}" alt="Gitar gacor" class="card-img" loading="lazy">
            <div class="card-body">
              <h3 class="card-title">Gitar gacor</h3>
              <p class="card-price">Rp.40.000 /hari</p>
              <div class="card-meta">
                <div class="card-rating">
                  <img src="{{ asset('assets/icons/star-rate-rounded.svg') }}" alt="Rating"> 5.0
                </div>
                <div class="card-renters">• 114 penyewa</div>
                <div class="card-location">Gedebage</div>
              </div>
            </div>
          </article>

        </div>
      </div>
    </section>

    <section class="produk-section bg-subtle">
      <div class="container">
        <h2 class="section-title">Rekomendasi untuk Anda</h2>
        
        <div class="produk-grid">
          
          <article class="card">
            <img src="{{ asset('assets/img/produk/Rectangle-1910@2x.png') }}" alt="Set Kebaya brukat" class="card-img" loading="lazy">
            <div class="card-body">
              <h3 class="card-title">Set Kebaya brukat</h3>
              <p class="card-price">Rp.100.000 /hari</p>
              <div class="card-meta">
                <div class="card-rating">
                  <img src="{{ asset('assets/icons/star-rate-rounded.svg') }}" alt="Rating"> 5.0
                </div>
                <div class="card-renters">• 25 penyewa</div>
                <div class="card-location">Cibiru</div>
              </div>
            </div>
          </article>
          
          <article class="card">
            <img src="{{ asset('assets/img/produk/Rectangle-1911@2x.png') }}" alt="HT merk bagus" class="card-img" loading="lazy">
            <div class="card-body">
              <h3 class="card-title">HT merk bagus</h3>
              <p class="card-price">Rp.100.000 /hari</p>
              <div class="card-meta">
                <div class="card-rating">
                  <img src="{{ asset('assets/icons/star-rate-rounded.svg') }}" alt="Rating"> 5.0
                </div>
                <div class="card-renters">• 56 penyewa</div>
                <div class="card-location">Cicalengka</div>
              </div>
            </div>
          </article>
          
          <article class="card">
            <img src="{{ asset('assets/img/produk/Rectangle-1912@2x.png') }}" alt="Sound system lengkap" class="card-img" loading="lazy">
            <div class="card-body">
              <h3 class="card-title">Sound system lengkap</h3>
              <p class="card-price">Rp.100.000 /hari</p>
              <div class="card-meta">
                <div class="card-rating">
                  <img src="{{ asset('assets/icons/star-rate-rounded.svg') }}" alt="Rating"> 5.0
                </div>
                <div class="card-renters">• 21 penyewa</div>
                <div class="card-location">Majalaya</div>
              </div>
            </div>
          </article>
          
          <article class="card">
            <img src="{{ asset('assets/img/produk/Rectangle-1913@2x.png') }}" alt="Apple watch gen 2" class="card-img" loading="lazy">
            <div class="card-body">
              <h3 class="card-title">Apple watch gen 2</h3>
              <p class="card-price">Rp.100.000 /hari</p>
              <div class="card-meta">
                <div class="card-rating">
                  <img src="{{ asset('assets/icons/star-rate-rounded.svg') }}" alt="Rating"> 5.0
                </div>
                <div class="card-renters">• 12 penyewa</div>
                <div class="card-location">Cileunyi</div>
              </div>
            </div>
          </article>
          
          <article class="card">
            <img src="{{ asset('assets/img/produk/Rectangle-1914@2x.png') }}" alt="Tenda katering" class="card-img" loading="lazy">
            <div class="card-body">
              <h3 class="card-title">Tenda katering</h3>
              <p class="card-price">Rp.100.000 /hari</p>
              <div class="card-meta">
                <div class="card-rating">
                  <img src="{{ asset('assets/icons/star-rate-rounded.svg') }}" alt="Rating"> 5.0
                </div>
                <div class="card-renters">• 150 penyewa</div>
                <div class="card-location">Baleendah</div>
              </div>
            </div>
          </article>

        </div>
      </div>
    </section>

@endsection