$(document).ready(function() {

    $('#table-categoria').on('click', 'button.btn-delete', function(e) {
        e.preventDefault()

        let idcategoria = `idcategoria=${$(this).attr('id')}`

        Swal.fire({
            title: 'appAulaDS',
            text: 'Deseja realmente excluir esse registro?',
            type: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sim',
            cancelButtonText: 'Não'
        }).then((result => {
            if (result.value) {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    assync: true,
                    data: idcategoria,
                    url: 'src/categorias/modelo/delete-categoria.php',
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
            }
        }))
    })
})