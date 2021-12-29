@extends('layouts.app')

@section('content')
    <div for="uyeler" class="mb-2">Panonuzu görmesini istediğiniz kullanıcıları düzenleyin</div>
    @if(count($uyeler) > 0)
        @foreach ($uyeler as $uye)
            <div class="mb-1">
                <input type="checkbox" class="panolar" value="{{ $uye->id }}" {{ $uye->panos->contains(auth()->user()->id) ? "checked" : "" }}>
                <label for="{{ $uye->id }}">{{ $uye->name }}</label>
            </div>
        @endforeach
        <button class="btn-sm btn-primary mt-2" onclick="setPanos()">Güncelle</button>
    @else
        Şuan başka bir kullanıcı mevcut değil
    @endif
@endsection

@section('js')
<script type="text/javascript">

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"').attr('content')
        }
    });

    setPanos = function(){

        var panolar = [];
           $('.panolar').each(function(){
                if($(this).is(":checked"))
                {
                    panolar.push($(this).val());
                }
           });

        $.ajax({
            type: 'POST',
            url: "{{ route('userSetPanos') }}",
            data: {
                panolar : panolar,
            },
            success: function (data) {
                console.log(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                textStatus;
            }
        });

    }

</script>
@endsection
