<?php
include 'header.php';

function getZodiacSign($birthdate) {
    $xml = simplexml_load_file('signos.xml');
    $date = DateTime::createFromFormat('Y-m-d', $birthdate);
    $dayMonth = $date->format('d/m');

    foreach ($xml->signo as $signo) {
        $dataInicio = DateTime::createFromFormat('d/m', (string)$signo->dataInicio);
        $dataFim = DateTime::createFromFormat('d/m', (string)$signo->dataFim);

        // Ajusta a comparação para signos que cruzam o ano novo
        if ($dataInicio->format('m') > $dataFim->format('m')) {
            $dataFim->modify('+1 year');
        }

        $currentDate = DateTime::createFromFormat('d/m', $dayMonth);
        
        // Verifica se a data atual está dentro do intervalo do signo
        if (($currentDate >= $dataInicio && $currentDate <= $dataFim) ||
            ($dataInicio->format('m') == '12' && $currentDate >= $dataInicio && $currentDate <= DateTime::createFromFormat('d/m', '31/12')) ||
            ($dataFim->format('m') == '01' && $currentDate >= DateTime::createFromFormat('d/m', '01/01') && $currentDate <= $dataFim)) {
            return [
                'nome' => (string)$signo->signoNome,
                'descricao' => (string)$signo->descricao,
                'imagem' => (string)$signo->imagem
            ];
        }
    }
    return null;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $birthdate = $_POST['birthdate'];
    $zodiacSign = getZodiacSign($birthdate);

    echo "<div class='result'>";
    if ($zodiacSign) {
        echo "<h2>Seu signo é: " . $zodiacSign['nome'] . "</h2>";
        echo "<p>" . $zodiacSign['descricao'] . "</p>";
        echo "<img src='img/" . $zodiacSign['imagem'] . "' alt='" . $zodiacSign['nome'] . "'>";
    } else {
        echo "<h2>Não foi possível determinar seu signo.</h2>";
    }
    echo "<form action='index.php' method='get'>
            <button type='submit' class='back-button'>Voltar</button>
          </form>";
    echo "</div>";
}

include 'footer.php';
?>
