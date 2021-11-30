<?php

use yii\helpers\Html;
?>
<div class="notificare_subiect_email">
    <div class="notificare_data">
        <div class="notificare_data_top">
            <div class="notificare_data_top_message">Salut, utilizator!</div>
            <div class="notificare_data_top_info">Aveti o notificare cu privire la subiectul subiect de pe forumului aplicatiei APLICATIE</div>
        </div>
        <div class="notificare_data_body">
            <div>Primiti aceasta notificare pentru ca sunteti abonat la subiectul SUBIECT</div>
            <div>Pentru a putea citi ultimele mesaje adaugate, accesati urmatorul link.</div>
        </div>
        <div class="notificare_data_footer">
            <div>Copyright APICATIA</div>
            <div>2021</div>
        </div>
    </div>
</div>

<style>
    .notificare_subiect_email{
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        justify-items: center;
        height: 80%;
        width: 80%;
        padding: 5%;
        box-sizing: border-box;
    }
    .notificare_data{
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 80%;
        min-width: 80%;
        box-sizing: border-box;

        border: 3px solid #2ecc71;
        border-radius: 4px;
    }
    .notificare_data_top{
        height: 3%;
        width: 100%;
        box-sizing: border-box;
    }
    .notificare_data_top_message{
        width: 100%;
        padding: 15px;
        background-color: #2ecc71;
        text-align: center;
        color: #fff;
        font-weight: bold;
        box-sizing: border-box;
        text-transform: uppercase;
    }
    .notificare_data_top_info{
        padding: 15px;
    }
    .notificare_data_body{
        width: 100%;
        min-height: 80%;
        margin-top: 2%;
    }
    .notificare_data_body div{
        padding: 15px;
    }
    .notificare_data_footer{
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-around;
        background-color: #2ecc71;
        color: #fff;
        width: 100%;
    }
    .notificare_data_footer div{
        padding: 5px;
    }
</style>
