$(document).ready(function() {
    $('.btn-update').click(function(e) {
        e.preventDefault()

        let dados = $('#form-categoria').serialize()

        $('input[type=checkbox]').each(function() {
            if (!this.checked) {
                dados += '&' + this.name + '=off'
            }
        })

        const datamodificacao = new Date().toLocaleString()

        dados += `&datamodificacao=${datamodificacao}`

        $.ajax({
            type: 'POST',
            dataType: 'json',
            assync: true,
            data: dados,
            url: 'src/categorias/modelo/update-categoria.php',
            success: function(dados) {
                Swal.fire({
                    title: 'appAulaDS',
                    text: dados.mensagem,
                    type: dados.tipo,
                    confirmButtonText: 'OK'
                })

                $('#modal-categoria').modal('hide')
                $('#table-categoria').DataTable().ajax.reload()
            }
        })
    })
})