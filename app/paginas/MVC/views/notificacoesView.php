<?php
require_once '../models/notificacoes.php';
class NotificacoesView
{
    
    public function mostrarNotificacoes(array $notificacoes)
    {
        $height = 0;
        if (count($notificacoes) > 0) {
            $height = 10    ;
        } else {
            $height = 5;
        }
        echo '<div class="container-fluid d-flex justify-content-center" >';
        
        echo '<div id="notification" class="border p-2"style="width: 75vw;">';
        echo '<h5>Notificações:</h5>';
        echo '<div id="notification" class=" overflow-auto" style="width: 74vw; height:';
        echo $height;
        echo 'vh;">';
        if (count($notificacoes) > 0) {
        foreach ($notificacoes as $notificacao) {
            echo '<div class="p-1 mb-1 bg-dark-subtle ">';
            echo '<p class="m-1">' . $notificacao . '</p>';
            echo '</div>';
        }} 
        else {
            echo '<h4>Nenhuma notificação encontrada.</h4>';
        }
        echo '</div>';
        if (count($notificacoes) > 0) {
        echo '<a href="../controllers/notificacoesController.php?funcao=limparNotificacoes" class="btn btn-primary mb-1">Limpar notificações</a>';
        }

        echo '</div>';
        echo '</div>';



    }

   
}
?>
