<?php
/*
	=================================================================
	# Wespa Juris 3.0 - Acompanhamento Processual Baseado na Web            
	# Copyright © 2012 Wespa Digital Ltda.
	# Developed by Weslley A. Harakawa (weslley@wcre8tive.com)
	#
	# O código deste software não pode ser vendido ou alterado
	# sem a autoização expressa de Wespa Digital Ltda. 
	# Mantenha os créditos do autor e os códigos de banners.
	#
	# Gratuíto para uso pessoal, não pode ser redistribuído.
	=================================================================
*/ 

// add_projectperms.php
$ADDPROJPERM_HEADER = "Adicionar permissões de usuários para o processo:";
$ADDPROJPERM_MAINTEXT = "Abaixo, você pode configurar quais pessoas terão acesso administrativo a este Processo. Você pooderá também dar permissões específicas para cada Usuário envolvido no processo.";
$ADDPROJPERM_PERMLIST = "Quem tem permissão para ver / acompanhar este processo";

// add_project.php
$ADDPROJECT_HEADER = "Adicionar Processo";
$ADDPROJECT_STEPS = "Etapas do Processo";
$ADDPROJECT_INSTRUCT = "Para adicionar completamente um Processo a um Cliente, há 4 epatas a serem seguidas:<p>
1. Adicione o Proceso, incluindo ao Processo, data de início, data limite, status e o valor dos honorários a serem cobrados.<p>
2. Adicione permissões ao Processo, habilitando/restringindo o acesso a este Processo.<p>
3. Adicione as várias Tarefas que irão auxiliar o acompanhamento do Processo.<p>
4. Adicione qualquer documento que possa ser útil para o acompanhamento do Processo.<p>";
$ADDPROJECT_MAINTEXT = "Preencha o formulário abaixo para adicionar um novo Processo a um Cliente.";
$ADDPROJECT_LEAVEBLANK = "deixe em branco em caso de não ter sido arquivada";
$ADDPROJECT_ADDNEW = "Adicionar Novo Processo";

// add_task.php
$ADDTASK_HEADER = "Adicionar Tarefas";
$ADDTASK_ASSIGNUSER = "Associar esta Tarefa a um Usuário";
$ADDTASK_ASSIGNTO = "Associar a";
$ADDTASK_MAINTEXT = "Preencha o formulário abaixo para adicioanr uma nova Tarefa ao Processo";
$ADDTASK_CLIENTFIRST = "Antes escolha um Cliente";
$ADDTASK_ADDNEW = "Adicionar Nova Tarefa";
$ADDTASK_HASBEENADDED = "foi adicionada a este Processo";

// all_projects.php
$ALLPROJECTS_MAINTEXT = "Abaixo estã uma lista de todos os Procesos, processos arquivados, em andamento e aqueles que estão em atraso. Clique sobre um Processo para ver mais detalhes sobre ele.";
$ALLPROJECTS_ALLPROJ = "Todos os Processos";
$ALLPROJECTS_NOPASTPROJ = "Náo há Processos em atraso.";

// delete_project.php
$DPROJECT_HEADER = "Excluir Processo";
$DPROJECT_INSTRUCT = "Certifique-se de que deseja realmente excluir este Processo clicando no botão de Excluir Processo. A ação não poderá ser revertida.";
$DPROJECT_SURE = "Tem certeza de que deseja excluir este processo?";
$DPROJECT_CONFIRM = "Esta ação não poderá ser revertida. Ao excluir este Processo, junto com ele você vai excluir também os documentos publicados neste processo, as Anotações tartefas e todos os outros itens associados a este Processo.<p>
Se estã certo de que deseja excluir este processo de forma <b>permanente</b>, clique no botão abaixo.";
$DPROJECT_DELETE = "Excluir Este Processo";

// edit_project.php
$EDITPROJECT_HEADER = "Editar Processo";
$EDITPROJECT_MAINTEXT = "Modifique as informações abaixo para editar o Processo.";
$EDITPROJECT_SAVE = "Salvar Processo";

// edit_task.php
$EDITTASK_HEADER = "Editar Tarefa";
$EDITTASK_MAINTEXT = "Modifique as informações abaixo para editar a Tarefa.";
$EDITTASK_TASKINFO = "Informações sobre a Tarefa";
$EDITTASK_SAVE = "Salvar Tarefa";

// project.php
$PROJECT_DESCRIPTION = "Descrição do Processo";
$PROJECT_STATUS = "Status do Processo";
$PROJECT_PROJUSERS = "Usuários envolvidos neste Processo";

// projects.php
$PROJECTS_MAINTEXT = "Abaixo, a lista de processos em andamento e também dos 10 últimos processos arquivados. Clique sobre um dos processos para ver mais detalhes sobre ele";
$PROJECTS_DELETE = "foi excluido ao longo de todo o sistema com todas as tarefas, documentos, anotações e coisas a fazer relacionadas a este Processo.";
$PROJECTS_PROJECTS = "Processos";
$PROJECTS_ACTIVE = "Processos em andamento";
$PROJECTS_NOPROJ = "Nenhum Processo";
$PROJECTS_PASTDUE = "Processos arquivados";
$PROJECTS_PROJFOR = "Processos em";
$PROJECTS_LAST10 = "Os 10 últimos processos arquivados";
$PROJECTS_BYCLIENT = "Processos por Clientes";
$PROJECTS_SELECTCLIENT = "Selecione na lista abaixo um Cliente para ver os processos relativos a este.";

// tasks.php
$TASKS_TASKSFOR = "Tarefas para";
$TASKS_ASSIGNEDTO = "Tarefas designadas para";
$TASKS_TASKS = "Tarefas";
$TASKS_VIEWOTHER = "tarefas em outros processos";
$TASKS_NOTASKS = "Não há tarefas";
$TASKS_ACTIVE = "Tarefas Ativas";
$TASKS_PAST = "Tarefas arquivadas";
$TASKS_BYCLIENT = "Tarefas por Cliente";
$TASKS_BYCINSTRUCT = "Selecione um Cliente abaixo para ver as Tarefas que foram designadas a ele.";
$TASKS_BYUSER = "Tarefas por Usuário";
$TASKS_BYUINSTRUCT = "Selecione um Usuário abaixo para ver as Tarefas que foram designadas a ele.";

// to do list
$TODO_CLIENT = "Lista de Atribuições ao Cliente";
$TODO_NOITEMS = "Não há nenhuma pendência";
$TODO_DUE = "concluído";

// add_todo.php
$ADDTODO_HEADER = "Adicionar Providências";
$ADDTODO_ITEMS = "Lista de Providências";
$ADDTODO_INSTRUCT = "Adicione ordens e pedidos que devem ser feitos por seu cliente para você. Eles poderão ver a lista de coisas a serem feitas por eles a qualquer momento.";
$ADDTODO_MAINTEXT = "Preencha o formulário abaixo para adicioanr coisas que precisam ser feitas em Clientes e Processos.";
$ADDTODO_TODOITEM = "Lista de ações a serem feitas";
$ADDTODO_INSTRUCT = "";
$ADDTODO_ADDNEW = "Adicionar";
$ADDTODO_ADDED = "Uma ação que precisa ser feita pelo cliente foi adicionada ao processo.";
?>
