<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráfico Personalizável com PHP e Chart.js</title>
    <link rel="stylesheet" type="text/css" href="principal.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <header>
        <div class="header-content">
            <a href="index.php"><img class="header-logo" src="imagem/slogan.png" alt="Slogan"></a>
            <h1>Gráfico Personalizável</h1>
            <div class="header-buttons">
                <button id="themeToggle">Trocar Tema</button>
                <button id="clearChart">Limpar Gráfico</button>
                <button id="editChart">Editar Valores</button>
            </div>
        </div>
    </header>
    
    <div class="container">
        <aside class="sidebar">
            <h2>Configurações do Gráfico</h2>

            <label for="chartTitle">Nome do Gráfico:</label>
            <input type="text" id="chartTitle" placeholder="Digite o nome do gráfico">

            <label for="chartType">Tipo de Gráfico:</label>
            <select id="chartType">
                <option value="bar">Barras</option>
                <option value="line">Linhas</option>
                <option value="pie">Pizza</option>
                <option value="doughnut">Rosca</option>
                <option value="radar">Radar</option>
                <option value="polarArea">Área Polar</option>
            </select>

            <label for="numColumns">Quantidade de Colunas:</label>
            <input type="number" id="numColumns" min="1" max="10" placeholder="Escolha a quantidade de colunas">
            <button id="setColumns">Definir Colunas</button>
            
            <div id="data">
                <h2>Adicionar Dados</h2>
                <form id="dataForm">
                    <div id="formFields"></div>
                    <button type="submit">Salvar</button>
                </form>
            </div>

            <div id="editDataContainer" style="display: none;">
                <h2>Editar Dados do Gráfico</h2>
                <form id="editDataForm">
                   <div id="editFormFields"></di>
                  <button type="submit">Salvar Alterações</button>
                </form>
            </div>


            <div class="color-picker">
                <h2>Escolha as Cores</h2>
                <label for="backgroundColor">Cor de Fundo:</label>
                <input type="color" id="backgroundColor" name="backgroundColor" value="#4bc0c0">
                
                <label for="borderColor">Cor da Borda:</label>
                <input type="color" id="borderColor" name="borderColor" value="#4bc0c0">
                
                <button id="applyTheme">Aplicar Tema</button>
            </div>
        </aside>

        <main class="content">
            <div class="chart-container">
                <canvas id="meuGrafico"></canvas>
            </div>
            <button class="download-button" id="downloadChart">Baixar Gráfico</button>
        </main>

    </div>

    <script>
        var meuGrafico;
        var chartType = 'bar'; // Tipo de gráfico padrão

        // Função para criar e atualizar o gráfico
        function fetchData() {
            fetch('data.php')
                .then(response => response.json())
                .then(data => {
                    var ctx = document.getElementById('meuGrafico').getContext('2d');
                    if (meuGrafico) {
                        meuGrafico.destroy(); // Destroi o gráfico anterior antes de criar um novo
                    }
                    meuGrafico = new Chart(ctx, {
                        type: chartType,
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: data.title || 'Meu Dataset',
                                data: data.values.map(value => {
                                    // Exibe valores como porcentagem se necessário
                                    return typeof value === 'string' && value.endsWith('%') 
                                        ? parseFloat(value) 
                                        : parseFloat(value);
                                }),
                                backgroundColor: data.colors,
                                borderColor: document.getElementById('borderColor').value,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            var value = context.raw;
                                            var isPercentage = data.values[context.dataIndex].endsWith('%');
                                            return context.dataset.label + ': ' + (isPercentage ? value + '%' : value);
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function(value) {
                                            // Exibe valores em porcentagem se necessário
                                            return value.toString().endsWith('%') ? value : value + '%';
                                        }
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Erro ao obter dados:', error));
        }

        // Atualiza o formulário com a quantidade de colunas escolhida
        document.getElementById('setColumns').addEventListener('click', function() {
            var numColumns = parseInt(document.getElementById('numColumns').value);
            var formFields = document.getElementById('formFields');
            formFields.innerHTML = ''; // Limpa campos anteriores
            if (numColumns > 0) {
                for (var i = 0; i < numColumns; i++) {
                    formFields.innerHTML += `
                        <label for="label${i}">Nome da Coluna ${i + 1}:</label>
                        <input type="text" id="label${i}" name="label${i}" required placeholder="Nome da coluna ${i + 1}">

                        <label for="value${i}">Valor ${i + 1}:</label>
                        <input type="text" id="value${i}" name="value${i}" required placeholder="Valor para a coluna ${i + 1} (ex: 10 ou 10%)">

                        <label for="color${i}">Cor da Coluna ${i + 1}:</label>
                        <input type="color" id="color${i}" name="color${i}" class="color-column" value="#4bc0c0">
                    `;
                }
                document.getElementById('dataFormContainer').style.display = 'block'; // Mostra o formulário
            }
        });

        // Envia os dados do formulário via AJAX
        document.getElementById('dataForm').addEventListener('submit', function(e) {
            e.preventDefault();
            var numColumns = parseInt(document.getElementById('numColumns').value);
            var chartTitle = document.getElementById('chartTitle').value;
            var data = [];
            for (var i = 0; i < numColumns; i++) {
                var label = document.getElementById('label' + i).value;
                var value = document.getElementById('value' + i).value;
                var color = document.getElementById('color' + i).value;
                data.push({
                    label: label,
                    value: value,
                    color: color
                });
            }

            fetch('data.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ title: chartTitle, data: data })
            })
            .then(response => response.json())
            .then(() => {
                fetchData(); // Atualiza o gráfico com os novos dados
                document.getElementById('dataForm').reset(); // Limpa o formulário
            })
            .catch(error => console.error('Erro ao enviar dados:', error));
        });

        // Atualiza o formulário de edição com os dados atuais
document.getElementById('editChart').addEventListener('click', function() {
    var editDataContainer = document.getElementById('editDataContainer');
    var editFormFields = document.getElementById('editFormFields');
    
    fetch('data.php')
        .then(response => response.json())
        .then(data => {
            var numColumns = data.labels.length;
            editFormFields.innerHTML = ''; // Limpa campos anteriores
            
            for (var i = 0; i < numColumns; i++) {
                editFormFields.innerHTML += 
                    `<label for="editLabel${i}">Nome da Coluna ${i + 1}:</label>
                    <input type="text" id="editLabel${i}" name="editLabel${i}" value="${data.labels[i]}" required placeholder="Nome da coluna ${i + 1}">

                    <label for="editValue${i}">Valor ${i + 1}:</label>
                    <input type="text" id="editValue${i}" name="editValue${i}" value="${data.values[i]}" required placeholder="Valor para a coluna ${i + 1} (ex: 10 ou 10%)">

                    <label for="editColor${i}">Cor da Coluna ${i + 1}:</label>
                    <input type="color" id="editColor${i}" name="editColor${i}" value="${data.colors[i]}">`;
            }
            editDataContainer.style.display = 'block'; // Mostra o formulário de edição

            // Animação de rolagem para a seção de edição
            editDataContainer.scrollIntoView({ behavior: 'smooth' });
        })
        .catch(error => console.error('Erro ao obter dados para edição:', error));
});

        // Envia os dados editados via AJAX
        document.getElementById('editDataForm').addEventListener('submit', function(e) {
            e.preventDefault();
            var numColumns = document.querySelectorAll('[id^="editLabel"]').length;
            var chartTitle = document.getElementById('chartTitle').value;
            var data = [];
            for (var i = 0; i < numColumns; i++) {
                var label = document.getElementById('editLabel' + i).value;
                var value = document.getElementById('editValue' + i).value;
                var color = document.getElementById('editColor' + i).value;
                data.push({
                    label: label,
                    value: value,
                    color: color
                });
            }

            fetch('data.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ title: chartTitle, data: data })
            })
            .then(response => response.json())
            .then(() => {
                fetchData(); // Atualiza o gráfico com os novos dados
                document.getElementById('editDataForm').reset(); // Limpa o formulário de edição
                document.getElementById('editDataContainer').style.display = 'none'; // Esconde o formulário de edição
            })
            .catch(error => console.error('Erro ao enviar dados editados:', error));
        });

        // Atualiza o tipo de gráfico quando o usuário seleciona uma nova opção
        document.getElementById('chartType').addEventListener('change', function() {
            chartType = this.value;
            fetchData(); // Re-renderiza o gráfico com o novo tipo
        });

        // Alterna entre modo claro e escuro
        document.getElementById('themeToggle').addEventListener('click', function() {
            document.body.classList.toggle('dark-mode');
            var isDarkMode = document.body.classList.contains('dark-mode');
            document.querySelectorAll('.sidebar, .content').forEach(element => {
                element.classList.toggle('dark-mode', isDarkMode);
            });
        });

        // Aplica o tema selecionado pelo usuário
        document.getElementById('applyTheme').addEventListener('click', function() {
            fetchData(); // Atualiza o gráfico para refletir as novas cores
        });

        // Limpa o gráfico e os dados
        document.getElementById('clearChart').addEventListener('click', function() {
            fetch('data.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ clear: true })
            })
            .then(response => response.json())
            .then(() => {
                if (meuGrafico) {
                    meuGrafico.destroy(); // Destroi o gráfico atual
                }
                document.getElementById('dataFormContainer').style.display = 'none'; // Esconde o formulário
            })
            .catch(error => console.error('Erro ao limpar dados:', error));
        });

        // Baixa o gráfico como imagem
        document.getElementById('downloadChart').addEventListener('click', function() {
            var link = document.createElement('a');
            link.href = meuGrafico.toBase64Image();
            link.download = 'grafico.png';
            link.click();
        });

        // Inicializa o gráfico com os dados do arquivo PHP
        fetchData();
    </script>
</body>
</html>
