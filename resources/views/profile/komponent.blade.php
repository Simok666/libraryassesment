@extends('layout.admin')

@section('title', 'Komponen Perpustakaan')
@section('title_page', 'Komponen Perpustakaan')
@section('desc_page', '')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title"></h4>
    </div>
    <div class="card-body">
        <form id="form-components">
            @include('components.table-pagenation', ['table' => 'components' , 'url' => '/api/v1/user/getSubKomponen' , 'headers' => [
            "NO.",
            "KOMPONEN" ,
            "JUMLAH INDIKATOR KUNCI (IK)" ,
            "SKOR SUBKOMPONEN" ,
            "BOBOT" ,
            "NILAI" ,
            "BUKTI DUKUNG",
            "CONTOH"
            ] , 'pagination' => false])
            <div class="row d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        GetData(req, "components", formatTable);
        
        $('.datatable-components').on('keyup', ".skor" ,  function() {
            let tr = $(this).parents('tr');
            ik = parseInt(tr.find('.jml-ik').text());
            skor = $(this).val();
            bobot = parseInt(tr.find('.bobot').text());
            nilai = parseInt(skor/ ( ik * 5) * bobot);
            tr.find('td.nilai').html(nilai);
            tr.find('input.nilai').val(nilai);
        })

        // submit form 
        $("#form-components").submit(function(e) {
            e.preventDefault();
            loadingButton($("form"))
            ajaxDataFile(`{{ url('/api/v1/user/storeKomponen') }}`, 'POST', new FormData(this),
                function(resp) {
                    toast("Save data success", 'success');
                    loadingButton($("form"), false);
                    setTimeout(function() {
                        window.location = "{{ url('profile-buktifisik.html') }}";
                    }, 3000);
                },
                function (data) {
                    loadingButton($("form"), false)
                }
            );
        });
    });

    function formatTable(data) {
        var result = "";
        $.each(data, function(index, data) {
            if (data.title_komponens == "Inovasi dan Kreativitas") {
                result += `
                    <tr>
                        <td colspan="9" class="text-center" style="background-color:grey;color: white"> KOMPONEN PENDUKUNG </td>
                    </tr>
                `
            }
            result += `
                <tr>
                    <td>
                        ${index+1}
                        <input type="hidden" name="${index}[subkomponen_id]" value="${data.id}">
                        <input type="hidden" class="nilai" name="${index}[nilai]" value="0">
                    </td>
                    <td>${data.title_komponens}</td>
                    <td class="jml-ik">${data.jumlah_indikator_kunci}</td>
                    <td><input required class="form-control skor" name="${index}[skor_subkomponen]" type="number" value="0"></td>
                    <td class="bobot">${data.bobot}</td>
                    <td class="nilai">0</td>
                    <td><input required class="form-control" name="${index}[bukti_dukung]" type="file"></td>
                    <td>
                        ${(!empty(data.contoh)) ? `<a href="${data.contoh[0].url}" target="_blank">View File Contoh</a>` : `-`}
                    </td>
                </tr>
            `
        });
        return result;
    }

</script>
@endsection
