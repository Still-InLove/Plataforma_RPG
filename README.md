# Taverna da Dragonesa

Uma plataforma web para a comunidade de RPG, permitindo que usuários criem um perfil, publiquem conteúdo sobre sistemas e campanhas, e visualizem publicações de outros membros.

---

### Funcionalidades Implementadas

* **Autenticação de Usuário:**
    * Sistema de login e cadastro.
    * Verificação de login persistente utilizando **`localStorage`** para armazenar um token.
   
* **Navegação Dinâmica:**
    * A barra de navegação superior exibe a opção **"Entrar / Cadastrar"** para usuários não autenticados.
    * Para usuários logados, a barra exibe uma miniatura de foto de perfil e um link de **"Sair"**.
    * O menu superior é **"sticky"**, seguindo a rolagem da página para garantir fácil acesso.
   
* **Gerenciamento de Publicações:**
    * Visualização de todas as publicações na página inicial.
    * Visualização das publicações do usuário logado na página de perfil.
   
* **Estrutura de Conteúdo:**
    * Página inicial com seções para "Sistemas e Campanhas", "Sobre a Taverna" e "Contato".
    * Página de perfil dedicada para cada usuário.

---

### Arquitetura e Tecnologia

* **Frontend:**
    * **HTML5:** Estrutura básica das páginas.
    * **CSS3:** Estilização completa do site, utilizando Flexbox e media queries para responsividade. As variáveis CSS (`:root`) foram usadas para manter a consistência de cores.
      
    * **JavaScript (Vanilla):** Lógica dinâmica para manipulação do DOM, controle de autenticação (`localStorage`) e requisições assíncronas (`fetch`) para o backend.
      
* **Backend (Conceptual):**
    * **PHP:** Linguagem de programação do lado do servidor para processar requisições de autenticação e gerenciamento de dados.
    * **Banco de Dados (implícito):** Armazenamento de informações de usuários (nome, e-mail) e publicações (título, tipo, descrição, autor).

* **Comunicação:** A comunicação entre o frontend (JavaScript) e o backend (PHP) é feita através de requisições **`fetch`** que enviam e recebem dados no formato JSON.

### Estrutura dos arquivos

    /novo_projeto/
    ├── estilo.css
    ├── index.html
    ├── perfil.html
    ├── publicar.html
    ├── login.html
    ├── cadastro.html
    ├── listar_publicacoes.php
    ├── perfil.php
    ├── login.php
    └── cadastro.php

---

---

### Requisitos de Instalação e Execução

* **Servidor:** É necessário um servidor web que suporte **PHP**, como **XAMPP**, WAMP ou Laragon.
  
* **Banco de Dados:** Uma base de dados (ex: MySQL) com tabelas para usuários e publicações.
  
* **Execução:** O projeto pode ser acessado em um navegador web a partir do servidor local, por exemplo: `http://localhost/novo_projeto/`.
  
---
