@extends('layouts.app')

@section('content')
<div class="page-container checkout-container">
<div class="page-header"><h1>Checkout</h1></div>
<div class="checkout-layout">
<div class="checkout-left">
<div class="checkout-card">
@php
$images=$rental->item->image ?? [];
$img=is_array($images)&&count($images)?$images[0]:null;
$days=$rental->start_date->diffInDays($rental->end_date)+1;
$deposit=$rental->item->has_deposit ? $rental->item->deposit_amount : 0;
$total=$payment->amount+$deposit;
@endphp
<div class="co-item-header">
@if($img)
<img src="{{ asset('storage/'.$img) }}" class="co-item-img">
@endif
<div class="co-item-title-box">
<h2>{{ $rental->item->name }}</h2>
<p class="co-owner">Disewakan oleh <strong>{{ $rental->owner->name }}</strong></p>
</div></div>
<div class="co-details-list">
<div>Jadwal : {{ $rental->start_date->format('d M Y') }} - {{ $rental->end_date->format('d M Y') }}</div>
<div>Durasi : {{ $days }} hari</div>
<div>Metode : {{ strtoupper($rental->delivery_method ?? '-') }}</div>
</div>
</div>
</div>
<div class="checkout-right">
<div class="checkout-card">
<h3>Pembayaran</h3>
<div>Biaya Sewa : Rp {{ number_format($payment->amount,0,',','.') }}</div>
@if($deposit>0)
<div>Deposit : Rp {{ number_format($deposit,0,',','.') }}</div>
@endif
<hr>
<h3>Total : Rp {{ number_format($total,0,',','.') }}</h3>

@if($payment->payment_status != 'paid')

<button
id="pay-button"
class="btn-co-pay">

Bayar Sekarang

</button>

@endif

<hr>

<form
action="{{ route('payment.demo.success',$rental) }}"
method="POST">

@csrf

</form>

@if(isset($payment) && $payment->payment_status == 'expired')

<div class="alert alert-warning mt-3">

    QRIS telah kedaluwarsa.

    Silakan buat QR baru.

</div>

<form
action="{{ route('checkout.retry',$rental) }}"
method="POST">

    @csrf

    <button
    class="btn btn-warning w-100">

        Bayar Lagi

    </button>

</form>

@endif

</div>
</div>
</div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js"
data-client-key="{{ config('midtrans.client_key') }}">
</script>

<script>

const payButton = document.getElementById('pay-button');

if(payButton){

    payButton.addEventListener('click',function(){

        payButton.disabled = true;

        payButton.innerHTML =
        'Memproses...';

        if(!'{{ $snapToken }}'){

            alert('Snap Token tidak tersedia.');

            payButton.disabled=false;

            payButton.innerHTML='Bayar Sekarang';

            return;

        }

        snap.pay('{{ $snapToken }}',{

            onSuccess:function(result){

                payButton.innerHTML='Berhasil';

                setTimeout(function(){

                    window.location.href=
                    "{{ route('riwayat.transaksi.penyewa') }}";

                },1500);

            },

            onPending:function(result){

                alert(
                'Pembayaran masih menunggu penyelesaian.'
                );

                payButton.disabled=false;

                payButton.innerHTML='Bayar Sekarang';

            },

            onError:function(result){

                alert(
                'Terjadi kesalahan pembayaran.'
                );

                payButton.disabled=false;

                payButton.innerHTML='Bayar Sekarang';

            },

            onClose:function(){

                payButton.disabled=false;

                payButton.innerHTML='Bayar Sekarang';

            }

        });

    });

}
    
</script>
@endsection
