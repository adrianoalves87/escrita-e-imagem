<?php
// Conectar ao banco de dados (substitua os valores pelos seus dados reais)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jp";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Receber os dados do formulário
$email = $_POST['email'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Armazenar a senha de forma segura

// Estilo CSS para o loader
echo '
<style>
    #loading {
        display: flex;
        align-items: center;
        justify-content: center;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.8);
        z-index: 9999;
    }

    #loading img {
        width: 50px;
        height: 50px;
        margin-right: 10px;
        animation: spin 1s infinite linear;
    }

    #loading p {
        font-size: 20px;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>';

// Adiciona o loader e a mensagem na página
echo '<div id="loading"><img src="./lood/sua_imagem_de_loading.png" alt="Loading"><p>Aguarde...</p></div>';

// Preparar a consulta SQL usando prepared statement
$stmt = $conn->prepare("INSERT INTO usuarios (email, senha) VALUES (?, ?)");
$stmt->bind_param("ss", $email, $senha);

// Executar a consulta
if ($stmt->execute()) {
    echo "<script>
              // Remover o elemento de loading após 2 segundos (pode ajustar conforme necessário)
              setTimeout(function() {
                  document.getElementById('loading').style.display = 'none';
                  window.location.href = 'https://adrianoalves87.github.io/site-oficina-automotiva/';
              }, 2000);
          </script>";
} else {
    echo "Erro ao cadastrar: " . $stmt->error;
}

// Fechar a conexão
$stmt->close();
$conn->close();
?>
