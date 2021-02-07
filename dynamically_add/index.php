<?php
include('../conexao.php');

if (!empty($_POST)) {

    $names = [];

    //var_dump($_POST);
    if (count($_POST) > 0) {
        foreach ($_POST['name'] as $key => $value):
            if (trim($value) != '')
                $names[] = "('{$value}')";
        endforeach;
    }

    $name = join(",", $names);
    $query = "INSERT INTO user (name) VALUES {$name}";
    $result = mysqli_query($con, $query);

    if ($result) {
        echo "Dados salvo <br>";
    } else {
        echo "Erro ao salvar: " . mysqli_error($con) . " <br>";
    }

    echo '<pre>';
    print_r($query);
    echo '</pre>';
    exit;
}

?>

<html>

<?php
require '../head.php'
?>

<body>
<style>
    body {
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
<div class="container">
    <div class="col-md-10">
        <form id="form-name">
            <table id="tabela" class="table table-bordered">
                <tr>
                    <td>
                        <input
                                id="name"
                                type="text"
                                class="form-control"
                                name="name[]"
                                placeholder="Digite seu nome"
                        >
                    </td>
                    <td class="text-center">
                        <button type="button" id="add_more" class="btn btn-success">Adicionar mais</button>
                    </td>
                </tr>
            </table>
            <div class="form-group">
                <input id="submit" class="btn btn-success" style="width: 180px" type="submit" value="Enviar">
            </div>
        </form>
    </div>

    <div class="row">
        <div class="col-md-10">
            <h4>Retorno</h4>
            <br>
            <div style="width: 100%;height: auto;border: #444" id="retorno">

            </div>
        </div>
    </div>
</div>

<?php
$html = <<< HTML

HTML;

?>
<script>
    console.log('<?= $html?>');
    $(document).ready(() => {
        var i = 1;


        $("#add_more").click(() => {
            i++;
            var input = '<tr id="row_' + i + '"><td><input id="name" type="text" class="form-control" name="name[]" placeholder="Digite seu nome"> '
                + '</td>' +
                '<td class="text-center"><button id="' + i + '" type="button" name="remove" class="btn_remove btn btn-danger">Remover</button></td>' +
                '</tr>';

            $("#tabela").append(input);
        });

        $(document).on("click", ".btn_remove",function (){
            var button_id = $(this).attr('id');
            $("#row_" + button_id).remove();
        });


        $("#submit").click(e => {
            e.preventDefault();

            $.ajax({
                url: "index.php",
                method: "POST",
                data: $("#form-name").serialize(),
                success: dados => {
                    $("#retorno").html(dados);
                }
            });
        });
    });
</script>
</body>
</html>
