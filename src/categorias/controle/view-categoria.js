$(document).ready(function() {

    $('#table-categoria').on('click', 'button.btn-view', function(e) {
        e.preventDefault()

        $('.modal-title').empty()
        $('.modal-body').empty()

        $('.modal-title').append('Visualização de categoria')

        let idproduto = `idproduto=${$(this).attr('id')}`

        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            assync: true,
            data: idproduto,
            url: 'src/categorias/modelo/view-categoria.php',
            success: function(dado) {
                if (dado.tipo == "success") {
                    $('.modal-body').load('src/categorias/visao/form-categoria.html', function() {
                        $('#nome').val(dado.dados.nome)
                        $('#nome').attr('readonly', 'true')
                        $('#dataagora').val(dado.dados.datacriacao)

                        if (dado.dados.ativo == "N") {
                            $('#ativo').removeAttr('checked')
                        }

                        $('#ativo').attr('readolnly', 'true')

                    })
                    $('.btn-save').hide()
                    $('.btn-update').hide()
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