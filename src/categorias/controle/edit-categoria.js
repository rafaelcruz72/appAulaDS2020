$(document).ready(function() {

    $('#table-categoria').on('click', 'button.btn-edit', function(e) {
        e.preventDefault()

        $('.modal-title').empty()
        $('.modal-body').empty()

        $('.modal-title').append('Edição de categoria')

        let idcategoria = `idcategoria=${$(this).attr('id')}`

        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            assync: true,
            data: idcategoria,
            url: 'src/categorias/modelo/view-categoria.php',
            success: function(dado) {
                if (dado.tipo == "success") {
                    $('.modal-body').load('src/categorias/visao/form-categoria.html', function() {
                        $('#nome').val(dado.dados.nome)
                        $('#dataagora').val(dado.dados.datacriacao)

                        if (dado.dados.ativo == "N") {
                            $('#ativo').removeAttr('checked')
                        }

                        $('#idcategoria').val(dado.dados.idcategoria)

                    })
                    $('.btn-save').hide()
                    $('.btn-update').show()
                    $('#modal-categoria').modal('show')
                } else {
                    Swal.fire({
                        title: 'appAulaDS',
                        text: dado.mensagem,
                        type: dado.tipo,
                        confirmButtonText: 'OK'
                    })
                }
            }
        })

    })

})