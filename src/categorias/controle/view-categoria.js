$(document).ready(function() {

    $('#table-categoria').on('click', 'button.btn-view', function(e) {
        e.preventDefault()

        $('.modal-title').empty()
        $('.modal-body').empty()

        $('.modal-tile').append('Visualização de categoria')

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
                        $('#nome').attr('readonly', 'true')
                        $('#dataagora').val(dado.dados.nome)
                        $('#ativo').val(dado.dados.ativo)
                    })
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