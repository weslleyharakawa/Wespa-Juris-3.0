-- phpMyAdmin SQL Dump
-- version 2.6.3-pl1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Nov 11, 2009 at 05:11 AM
-- Server version: 4.1.22
-- PHP Version: 5.2.4
-- 
-- Database: `wespadig_juris`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `ttcm_account`
-- 

CREATE TABLE `ttcm_account` (
  `account_id` int(11) NOT NULL auto_increment,
  `client_id` int(10) NOT NULL default '0',
  `status` varchar(255) NOT NULL default '',
  KEY `account_id` (`account_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- 
-- Dumping data for table `ttcm_account`
-- 

INSERT INTO `ttcm_account` VALUES (11, 11, 'Não foi iniciado');
INSERT INTO `ttcm_account` VALUES (10, 10, 'Não foi iniciado');

-- --------------------------------------------------------

-- 
-- Table structure for table `ttcm_admin`
-- 

CREATE TABLE `ttcm_admin` (
  `company_id` int(10) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `company` varchar(255) NOT NULL default '',
  `address1` varchar(255) NOT NULL default '',
  `address2` varchar(255) NOT NULL default '',
  `city` varchar(255) NOT NULL default '',
  `state` varchar(255) NOT NULL default '',
  `zip` varchar(15) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `aim` varchar(255) NOT NULL default '',
  `icq` varchar(255) NOT NULL default '',
  `msn` varchar(255) NOT NULL default '',
  `yahoo` varchar(255) NOT NULL default '',
  `skype` varchar(255) NOT NULL default '',
  `phone` varchar(25) NOT NULL default '',
  `phone_alt` varchar(25) NOT NULL default '',
  `fax` varchar(25) NOT NULL default '',
  `country` varchar(255) NOT NULL default '',
  `logo` varchar(255) NOT NULL default '',
  `currency` varchar(25) NOT NULL default '',
  `serverdiff` tinyint(2) NOT NULL default '0',
  `date_format` varchar(255) NOT NULL default '',
  `file_ext` varchar(255) NOT NULL default '',
  `def_aclient` varchar(255) NOT NULL default '',
  `def_aproject` varchar(255) NOT NULL default '',
  `def_projdone` varchar(255) NOT NULL default '',
  `def_atask` varchar(255) NOT NULL default '',
  `def_taskdone` varchar(255) NOT NULL default '',
  `def_ainvoice` varchar(255) NOT NULL default '',
  `def_invdone` varchar(255) NOT NULL default '',
  `outcolor` varchar(8) NOT NULL default '',
  `overcolor` varchar(8) NOT NULL default '',
  `language` char(3) NOT NULL default '',
  `messages_active` tinyint(2) NOT NULL default '0',
  `clients_active` tinyint(2) NOT NULL default '0',
  `projects_active` tinyint(2) NOT NULL default '0',
  `files_active` tinyint(2) NOT NULL default '0',
  `help_active` tinyint(2) NOT NULL default '0',
  `upload_active` tinyint(2) NOT NULL default '0',
  `version` varchar(10) NOT NULL default '',
  KEY `company_id` (`company_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `ttcm_admin`
-- 

INSERT INTO `ttcm_admin` VALUES (1, 'Your Name', 'Seu Escritório de Advocacia', 'Endereço de seu escritório aqui', '', 'Baiiro', 'Cidade', 'CEP aqui', 'wespajuris@wespadigital.com', '', '', '', '', '', 'Seu telefone', 'Seu celular', 'Seu fax', 'Estado', 'images/logo_wespajuris.gif', 'R$', 0, '%e/%c/%Y', 'jpg,jpeg,gif,png,psd,zip,ai,pdf,doc', 'Não foi iniciado', 'Não foi iniciada', 'Finalizado', 'Não foi iniciada', 'Completa', '', '', '#ffffff', '#e8e8e8', 'eng', 1, 1, 1, 1, 1, 1, '.074');

-- --------------------------------------------------------

-- 
-- Table structure for table `ttcm_cfiles`
-- 

CREATE TABLE `ttcm_cfiles` (
  `file_id` int(8) NOT NULL auto_increment,
  `client_id` int(10) NOT NULL default '0',
  `project_id` int(8) NOT NULL default '0',
  `file` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `link` varchar(255) NOT NULL default '',
  `added` date NOT NULL default '0000-00-00',
  KEY `file_id` (`file_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `ttcm_cfiles`
-- 

INSERT INTO `ttcm_cfiles` VALUES (3, 11, 8, '4ª Etapa Programação.doc', 'Laudo Técnico', 'clientdir/11/ul/4ª Etapa Programação.doc', '2009-09-02');

-- --------------------------------------------------------

-- 
-- Table structure for table `ttcm_client`
-- 

CREATE TABLE `ttcm_client` (
  `client_id` int(10) NOT NULL auto_increment,
  `contact` int(10) NOT NULL default '0',
  `company` varchar(255) NOT NULL default '',
  `address1` varchar(255) NOT NULL default '',
  `address2` varchar(255) NOT NULL default '',
  `city` varchar(255) NOT NULL default '',
  `state` varchar(255) NOT NULL default '',
  `zip` varchar(15) NOT NULL default '',
  `country` varchar(255) NOT NULL default '',
  `phone` varchar(50) NOT NULL default '',
  `phone_alt` varchar(50) NOT NULL default '',
  `fax` varchar(50) NOT NULL default '',
  `logo` varchar(255) NOT NULL default '',
  KEY `client_id` (`client_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- 
-- Dumping data for table `ttcm_client`
-- 

INSERT INTO `ttcm_client` VALUES (11, 0, 'Construtora A', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `ttcm_client` VALUES (10, 0, 'Andrade Júnior', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

-- 
-- Table structure for table `ttcm_comments`
-- 

CREATE TABLE `ttcm_comments` (
  `comment_id` int(8) NOT NULL auto_increment,
  `message_id` int(8) NOT NULL default '0',
  `comment` text NOT NULL,
  `posted` datetime NOT NULL default '0000-00-00 00:00:00',
  `post_by` varchar(255) NOT NULL default '',
  KEY `comment_id` (`comment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `ttcm_comments`
-- 

INSERT INTO `ttcm_comments` VALUES (1, 6, 'Acho q nao da', '2009-08-27 22:42:52', 'JJ Consultores e Advogados');
INSERT INTO `ttcm_comments` VALUES (2, 8, 'ainda, não. No mais tardar segunda-feira.', '2009-08-31 17:02:26', 'JJ Consultores & Advogados');
INSERT INTO `ttcm_comments` VALUES (3, 8, 'tudo bem estou aguardando', '2009-09-02 17:06:24', 'José Advogado');

-- --------------------------------------------------------

-- 
-- Table structure for table `ttcm_files`
-- 

CREATE TABLE `ttcm_files` (
  `file_id` int(8) NOT NULL auto_increment,
  `type_id` int(8) NOT NULL default '0',
  `client_id` int(10) NOT NULL default '0',
  `project_id` int(8) NOT NULL default '0',
  `file` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `link` varchar(255) NOT NULL default '',
  `added` date NOT NULL default '0000-00-00',
  `task_id` int(10) NOT NULL default '0',
  KEY `file_id` (`file_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- 
-- Dumping data for table `ttcm_files`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `ttcm_filetype`
-- 

CREATE TABLE `ttcm_filetype` (
  `type_id` int(8) NOT NULL auto_increment,
  `file_type` varchar(255) NOT NULL default '',
  KEY `type_id` (`type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- 
-- Dumping data for table `ttcm_filetype`
-- 

INSERT INTO `ttcm_filetype` VALUES (2, 'Petição');
INSERT INTO `ttcm_filetype` VALUES (7, 'Alegações de Defesa');
INSERT INTO `ttcm_filetype` VALUES (8, 'Recurso');
INSERT INTO `ttcm_filetype` VALUES (10, 'Julgados do TCU');

-- --------------------------------------------------------

-- 
-- Table structure for table `ttcm_helpcat`
-- 

CREATE TABLE `ttcm_helpcat` (
  `cat_id` int(5) NOT NULL auto_increment,
  `category` varchar(255) NOT NULL default '',
  KEY `cat_id` (`cat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `ttcm_helpcat`
-- 

INSERT INTO `ttcm_helpcat` VALUES (2, 'Direito do Consumidor');
INSERT INTO `ttcm_helpcat` VALUES (3, 'INSS e IRPF no BDI');

-- --------------------------------------------------------

-- 
-- Table structure for table `ttcm_linkcats`
-- 

CREATE TABLE `ttcm_linkcats` (
  `cat_id` int(8) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  KEY `cat_id` (`cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `ttcm_linkcats`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `ttcm_links`
-- 

CREATE TABLE `ttcm_links` (
  `link_id` int(8) NOT NULL auto_increment,
  `client_id` int(8) NOT NULL default '0',
  `link_title` varchar(255) NOT NULL default '',
  `link_desc` text NOT NULL,
  `link` varchar(255) NOT NULL default '',
  `cat_id` int(8) NOT NULL default '0',
  KEY `link_id` (`link_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `ttcm_links`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `ttcm_messages`
-- 

CREATE TABLE `ttcm_messages` (
  `message_id` int(8) NOT NULL auto_increment,
  `client_id` int(8) NOT NULL default '0',
  `project_id` int(10) NOT NULL default '0',
  `message_title` varchar(255) NOT NULL default '',
  `message` text NOT NULL,
  `posted` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `replies` int(5) NOT NULL default '0',
  `post_by` varchar(255) NOT NULL default '',
  `verify_id` varchar(25) NOT NULL default '',
  KEY `message_id` (`message_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- 
-- Dumping data for table `ttcm_messages`
-- 

INSERT INTO `ttcm_messages` VALUES (8, 11, 0, 'Decisão', 'Você tem alguma decisão.', '2009-08-31 16:59:59', '2009-09-02 17:06:24', 0, 'José Advogado', 'LhUQeGWBTeMKBhVT');

-- --------------------------------------------------------

-- 
-- Table structure for table `ttcm_modules`
-- 

CREATE TABLE `ttcm_modules` (
  `module_id` int(3) NOT NULL auto_increment,
  `module` varchar(255) NOT NULL default '',
  `installed` tinyint(2) NOT NULL default '0',
  `active` tinyint(2) NOT NULL default '0',
  KEY `module_id` (`module_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- 
-- Dumping data for table `ttcm_modules`
-- 

INSERT INTO `ttcm_modules` VALUES (1, 'Basic Invoice Module', 0, 0);
INSERT INTO `ttcm_modules` VALUES (2, 'Advanced Invoice Module', 0, 0);
INSERT INTO `ttcm_modules` VALUES (3, 'Support Ticket System', 0, 0);
INSERT INTO `ttcm_modules` VALUES (4, 'Web Hosting Module', 0, 0);
INSERT INTO `ttcm_modules` VALUES (5, 'Hourly Tracking Module', 0, 0);
INSERT INTO `ttcm_modules` VALUES (6, 'Appointment Tracking Module', 0, 0);
INSERT INTO `ttcm_modules` VALUES (7, 'Lead Tracking Module', 0, 0);
INSERT INTO `ttcm_modules` VALUES (8, 'Process Tracking Module', 0, 0);
INSERT INTO `ttcm_modules` VALUES (9, 'Maintenance Tracking Module', 0, 0);
INSERT INTO `ttcm_modules` VALUES (10, 'Quoting / Proposal Module', 0, 0);
INSERT INTO `ttcm_modules` VALUES (11, 'Critique Module', 0, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `ttcm_notes`
-- 

CREATE TABLE `ttcm_notes` (
  `note_id` int(10) NOT NULL auto_increment,
  `client_id` int(10) NOT NULL default '0',
  `note` text NOT NULL,
  `project_id` int(10) NOT NULL default '0',
  KEY `note_id` (`note_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `ttcm_notes`
-- 

INSERT INTO `ttcm_notes` VALUES (3, 11, 'FALATA RECEBER A 2ª Parcela', 8);

-- --------------------------------------------------------

-- 
-- Table structure for table `ttcm_permfunctions`
-- 

CREATE TABLE `ttcm_permfunctions` (
  `function_id` int(11) NOT NULL auto_increment,
  `function` varchar(255) NOT NULL default '',
  `task` varchar(255) NOT NULL default '',
  KEY `function_id` (`function_id`)
) ENGINE=MyISAM AUTO_INCREMENT=121 DEFAULT CHARSET=latin1 AUTO_INCREMENT=121 ;

-- 
-- Dumping data for table `ttcm_permfunctions`
-- 

INSERT INTO `ttcm_permfunctions` VALUES (1, 'processos', 'ver');
INSERT INTO `ttcm_permfunctions` VALUES (2, 'processos', 'adicionar');
INSERT INTO `ttcm_permfunctions` VALUES (3, 'processos', 'editar');
INSERT INTO `ttcm_permfunctions` VALUES (4, 'processos', 'excluir');
INSERT INTO `ttcm_permfunctions` VALUES (5, 'links', 'adicionar');
INSERT INTO `ttcm_permfunctions` VALUES (6, 'links', 'excluir');
INSERT INTO `ttcm_permfunctions` VALUES (7, 'clientes', 'editar');
INSERT INTO `ttcm_permfunctions` VALUES (8, 'configura&ccedil;&otilde;es', 'editar');
INSERT INTO `ttcm_permfunctions` VALUES (9, 'mensagens', 'ver');
INSERT INTO `ttcm_permfunctions` VALUES (10, 'mensagens', 'ver');
INSERT INTO `ttcm_permfunctions` VALUES (11, 'mensagens', 'responder');
INSERT INTO `ttcm_permfunctions` VALUES (12, 'mensagens', 'editar');
INSERT INTO `ttcm_permfunctions` VALUES (13, 'mensagens', 'excluir');
INSERT INTO `ttcm_permfunctions` VALUES (14, 'clientes', 'ver');
INSERT INTO `ttcm_permfunctions` VALUES (15, 'clientes', 'adicionar');
INSERT INTO `ttcm_permfunctions` VALUES (16, 'clientes', 'editar');
INSERT INTO `ttcm_permfunctions` VALUES (17, 'clientes', 'excluir');
INSERT INTO `ttcm_permfunctions` VALUES (18, 'anota&ccedil;&otilde;es nos clientes', 'ver');
INSERT INTO `ttcm_permfunctions` VALUES (19, 'anota&ccedil;&otilde;es nos clientes', 'adicionar');
INSERT INTO `ttcm_permfunctions` VALUES (20, 'anota&ccedil;&otilde;es nos clientes', 'excluir');
INSERT INTO `ttcm_permfunctions` VALUES (21, 'documentos nos processos', 'ver');
INSERT INTO `ttcm_permfunctions` VALUES (22, 'documentos nos processos', 'adicionar');
INSERT INTO `ttcm_permfunctions` VALUES (23, 'documentos nos processos', 'editar');
INSERT INTO `ttcm_permfunctions` VALUES (24, 'documentos nos processos', 'excluir');
INSERT INTO `ttcm_permfunctions` VALUES (25, 'usu&aacute;rios', 'ver');
INSERT INTO `ttcm_permfunctions` VALUES (26, 'usu&aacute;rios', 'adicionar');
INSERT INTO `ttcm_permfunctions` VALUES (27, 'usu&aacute;rios', 'editar');
INSERT INTO `ttcm_permfunctions` VALUES (28, 'usu&aacute;rios', 'excluir');
INSERT INTO `ttcm_permfunctions` VALUES (29, 'informa&ccedil;&otilde;es sobre os clientes', 'ver');
INSERT INTO `ttcm_permfunctions` VALUES (30, 'informa&ccedil;&otilde;es sobre os clientes', 'editar');
INSERT INTO `ttcm_permfunctions` VALUES (31, 'links', 'ver');
INSERT INTO `ttcm_permfunctions` VALUES (32, 'links', 'adicionar');
INSERT INTO `ttcm_permfunctions` VALUES (33, 'links', 'excluir');
INSERT INTO `ttcm_permfunctions` VALUES (34, 'logomarca', 'ver');
INSERT INTO `ttcm_permfunctions` VALUES (35, 'logomarca', 'editar');
INSERT INTO `ttcm_permfunctions` VALUES (36, 'links nos processos', 'ver');
INSERT INTO `ttcm_permfunctions` VALUES (37, 'links nos processos', 'adicionar');
INSERT INTO `ttcm_permfunctions` VALUES (38, 'links nos processos', 'excluir');
INSERT INTO `ttcm_permfunctions` VALUES (39, 'enviar documentos processos', 'ver');
INSERT INTO `ttcm_permfunctions` VALUES (40, 'documentos dos clientes e usu�rios', 'excluir');
INSERT INTO `ttcm_permfunctions` VALUES (41, 'status do processo', 'ver');
INSERT INTO `ttcm_permfunctions` VALUES (42, 'status do processo', 'editar');
INSERT INTO `ttcm_permfunctions` VALUES (43, 'anota&ccedil;&otilde;es nos clientes', 'ver');
INSERT INTO `ttcm_permfunctions` VALUES (44, 'anota&ccedil;&otilde;es nos clientes', 'adicionar');
INSERT INTO `ttcm_permfunctions` VALUES (45, 'anota&ccedil;&otilde;es nos clientes', 'excluir');
INSERT INTO `ttcm_permfunctions` VALUES (46, 'listar tarefas', 'ver');
INSERT INTO `ttcm_permfunctions` VALUES (47, 'listar tarefas', 'adicionar');
INSERT INTO `ttcm_permfunctions` VALUES (48, 'listar tarefas', 'excluir');
INSERT INTO `ttcm_permfunctions` VALUES (49, 'tarefas nos processos', 'ver');
INSERT INTO `ttcm_permfunctions` VALUES (50, 'tarefas nos processos', 'adicionar');
INSERT INTO `ttcm_permfunctions` VALUES (51, 'tarefas nos processos', 'editar');
INSERT INTO `ttcm_permfunctions` VALUES (52, 'tarefas nos processos', 'excluir');
INSERT INTO `ttcm_permfunctions` VALUES (53, 'status dos processos', 'ver');
INSERT INTO `ttcm_permfunctions` VALUES (54, 'status dos processos', 'editar');
INSERT INTO `ttcm_permfunctions` VALUES (55, 'op&ccedil;&otilde;es de status', 'ver');
INSERT INTO `ttcm_permfunctions` VALUES (56, 'op&ccedil;&otilde;es de status', 'editar');
INSERT INTO `ttcm_permfunctions` VALUES (57, 'op&ccedil;&otilde;es de status', 'adicionar');
INSERT INTO `ttcm_permfunctions` VALUES (58, 'op&ccedil;&otilde;es de status', 'excluir');
INSERT INTO `ttcm_permfunctions` VALUES (59, 'tipos de arquivos', 'ver');
INSERT INTO `ttcm_permfunctions` VALUES (60, 'tipos de arquivos', 'adicionar');
INSERT INTO `ttcm_permfunctions` VALUES (61, 'tipos de arquivos', 'excluir');
INSERT INTO `ttcm_permfunctions` VALUES (62, 'ajuda e consultoria', 'ver');
INSERT INTO `ttcm_permfunctions` VALUES (63, 'categorias de ajuda', 'ver');
INSERT INTO `ttcm_permfunctions` VALUES (64, 'categorias de ajuda', 'adicionar');
INSERT INTO `ttcm_permfunctions` VALUES (65, 'categorias de ajuda', 'excluir');
INSERT INTO `ttcm_permfunctions` VALUES (66, 't&oacute;picos de ajuda', 'adicionar');
INSERT INTO `ttcm_permfunctions` VALUES (67, 't&oacute;picos de ajuda', 'editar');
INSERT INTO `ttcm_permfunctions` VALUES (68, 't&oacute;picos de ajuda', 'excluir');
INSERT INTO `ttcm_permfunctions` VALUES (69, 'faturas e pagamentos', 'ver');
INSERT INTO `ttcm_permfunctions` VALUES (70, 'faturas e pagamentos', 'adicionar');
INSERT INTO `ttcm_permfunctions` VALUES (71, 'faturas e pagamentos', 'editar');
INSERT INTO `ttcm_permfunctions` VALUES (72, 'faturas e pagamentos', 'excluir');
INSERT INTO `ttcm_permfunctions` VALUES (73, 'processos', 'ver');
INSERT INTO `ttcm_permfunctions` VALUES (74, 'lista de tarefas', 'ver');
INSERT INTO `ttcm_permfunctions` VALUES (75, 'dados do cliente', 'ver');
INSERT INTO `ttcm_permfunctions` VALUES (76, 'dados do cliente', 'editar');
INSERT INTO `ttcm_permfunctions` VALUES (77, 'status', 'ver');
INSERT INTO `ttcm_permfunctions` VALUES (78, 'mensagens', 'ver');
INSERT INTO `ttcm_permfunctions` VALUES (79, 'mensagens', 'adicionar');
INSERT INTO `ttcm_permfunctions` VALUES (80, 'mensagens', 'responder');
INSERT INTO `ttcm_permfunctions` VALUES (81, 'links nos clientes', 'ver');
INSERT INTO `ttcm_permfunctions` VALUES (82, 'tarefas nos processos', 'ver');
INSERT INTO `ttcm_permfunctions` VALUES (83, 'documentos nos processos', 'ver');
INSERT INTO `ttcm_permfunctions` VALUES (84, 'detalhes dos processos', 'ver');
INSERT INTO `ttcm_permfunctions` VALUES (85, 'documentos nos clientes', 'enviar');
INSERT INTO `ttcm_permfunctions` VALUES (86, 'documentos nos clientes', 'excluir');
INSERT INTO `ttcm_permfunctions` VALUES (87, 'ajuda e consultoria', 'ver');
INSERT INTO `ttcm_permfunctions` VALUES (88, 'p&aacute;gina de contato', 'ver');
INSERT INTO `ttcm_permfunctions` VALUES (89, 'faturas e pagamentos', 'ver');
INSERT INTO `ttcm_permfunctions` VALUES (90, 'lista de tarefas', 'checar');
INSERT INTO `ttcm_permfunctions` VALUES (91, 'documentos nos processos', 'ver / carregar');
INSERT INTO `ttcm_permfunctions` VALUES (92, 'e-mails', 'ser notificado de nova tarefa');
INSERT INTO `ttcm_permfunctions` VALUES (93, 'e-mails', 'ser notificado de novo documento');
INSERT INTO `ttcm_permfunctions` VALUES (94, 'e-mails', 'escrever mensagem');
INSERT INTO `ttcm_permfunctions` VALUES (95, 'e-mails', 'responder menagem');
INSERT INTO `ttcm_permfunctions` VALUES (96, 'e-mails', 'ser notificado de novo processo');
INSERT INTO `ttcm_permfunctions` VALUES (98, 'e-mails', 'nova resposta');
INSERT INTO `ttcm_permfunctions` VALUES (99, 'e-mails', 'ser notificado de novo documento');
INSERT INTO `ttcm_permfunctions` VALUES (100, 'processos', 'ver / gerenciar tudo');

-- --------------------------------------------------------

-- 
-- Table structure for table `ttcm_permissions`
-- 

CREATE TABLE `ttcm_permissions` (
  `perm_id` int(11) NOT NULL auto_increment,
  `section` varchar(255) NOT NULL default '',
  `function_id` int(11) NOT NULL default '0',
  `usertype` tinyint(2) NOT NULL default '0',
  KEY `perm_id` (`perm_id`)
) ENGINE=MyISAM AUTO_INCREMENT=121 DEFAULT CHARSET=latin1 AUTO_INCREMENT=121 ;

-- 
-- Dumping data for table `ttcm_permissions`
-- 

INSERT INTO `ttcm_permissions` VALUES (1, 'Processos', 1, 1);
INSERT INTO `ttcm_permissions` VALUES (2, 'Processos', 2, 1);
INSERT INTO `ttcm_permissions` VALUES (3, 'Processos', 3, 1);
INSERT INTO `ttcm_permissions` VALUES (4, 'Processos', 4, 1);
INSERT INTO `ttcm_permissions` VALUES (5, 'Administra&ccedil;&atilde;o', 5, 1);
INSERT INTO `ttcm_permissions` VALUES (6, 'Administra&ccedil;&atilde;o', 6, 1);
INSERT INTO `ttcm_permissions` VALUES (7, 'Administra&ccedil;&atilde;o', 7, 1);
INSERT INTO `ttcm_permissions` VALUES (8, 'Administra&ccedil;&atilde;o', 8, 1);
INSERT INTO `ttcm_permissions` VALUES (9, 'Mensagens', 9, 1);
INSERT INTO `ttcm_permissions` VALUES (10, 'Mensagens', 10, 1);
INSERT INTO `ttcm_permissions` VALUES (11, 'Mensagens', 11, 1);
INSERT INTO `ttcm_permissions` VALUES (12, 'Mensagens', 12, 1);
INSERT INTO `ttcm_permissions` VALUES (13, 'Mensagens', 13, 1);
INSERT INTO `ttcm_permissions` VALUES (14, 'Clientes e Usu&aacute;rios', 14, 1);
INSERT INTO `ttcm_permissions` VALUES (15, 'Clientes e Usu&aacute;rios', 15, 1);
INSERT INTO `ttcm_permissions` VALUES (16, 'Clientes e Usu&aacute;rios', 16, 1);
INSERT INTO `ttcm_permissions` VALUES (17, 'Clientes e Usu&aacute;rios', 17, 1);
INSERT INTO `ttcm_permissions` VALUES (18, 'Clientes e Usu&aacute;rios', 18, 1);
INSERT INTO `ttcm_permissions` VALUES (19, 'Clientes e Usu&aacute;rios', 19, 1);
INSERT INTO `ttcm_permissions` VALUES (20, 'Clientes e Usu&aacute;rios', 20, 1);
INSERT INTO `ttcm_permissions` VALUES (21, 'Processos', 21, 1);
INSERT INTO `ttcm_permissions` VALUES (22, 'Processos', 22, 1);
INSERT INTO `ttcm_permissions` VALUES (23, 'Processos', 23, 1);
INSERT INTO `ttcm_permissions` VALUES (24, 'Processos', 24, 1);
INSERT INTO `ttcm_permissions` VALUES (25, 'Clientes e Usu&aacute;rios', 25, 1);
INSERT INTO `ttcm_permissions` VALUES (26, 'Clientes e Usu&aacute;rios', 26, 1);
INSERT INTO `ttcm_permissions` VALUES (27, 'Clientes e Usu&aacute;rios', 27, 1);
INSERT INTO `ttcm_permissions` VALUES (28, 'Clientes e Usu&aacute;rios', 28, 1);
INSERT INTO `ttcm_permissions` VALUES (29, 'Clientes e Usu&aacute;rios', 29, 1);
INSERT INTO `ttcm_permissions` VALUES (30, 'Clientes e Usu&aacute;rios', 30, 1);
INSERT INTO `ttcm_permissions` VALUES (31, 'Clientes e Usu&aacute;rios', 31, 1);
INSERT INTO `ttcm_permissions` VALUES (32, 'Clientes e Usu&aacute;rios', 32, 1);
INSERT INTO `ttcm_permissions` VALUES (33, 'Clientes e Usu&aacute;rios', 33, 1);
INSERT INTO `ttcm_permissions` VALUES (34, 'Clientes e Usu&aacute;rios', 34, 1);
INSERT INTO `ttcm_permissions` VALUES (35, 'Clientes e Usu&aacute;rios', 35, 1);
INSERT INTO `ttcm_permissions` VALUES (36, 'Clientes e Usu&aacute;rios', 36, 1);
INSERT INTO `ttcm_permissions` VALUES (37, 'Clientes e Usu&aacute;rios', 37, 1);
INSERT INTO `ttcm_permissions` VALUES (38, 'Clientes e Usu&aacute;rios', 38, 1);
INSERT INTO `ttcm_permissions` VALUES (39, 'Documentos dos Clientes', 39, 1);
INSERT INTO `ttcm_permissions` VALUES (40, 'Documentos dos Clientes e Usu&aacute;rios', 40, 1);
INSERT INTO `ttcm_permissions` VALUES (41, 'Clientes e Usu&aacute;rios', 41, 1);
INSERT INTO `ttcm_permissions` VALUES (42, 'Clientes e Usu&aacute;rios', 42, 1);
INSERT INTO `ttcm_permissions` VALUES (43, 'Processos', 43, 1);
INSERT INTO `ttcm_permissions` VALUES (44, 'Processos', 44, 1);
INSERT INTO `ttcm_permissions` VALUES (45, 'Processos', 45, 1);
INSERT INTO `ttcm_permissions` VALUES (46, 'Processos', 46, 1);
INSERT INTO `ttcm_permissions` VALUES (47, 'Processos', 47, 1);
INSERT INTO `ttcm_permissions` VALUES (48, 'Processos', 48, 1);
INSERT INTO `ttcm_permissions` VALUES (49, 'Processos', 49, 1);
INSERT INTO `ttcm_permissions` VALUES (50, 'Processos', 50, 1);
INSERT INTO `ttcm_permissions` VALUES (51, 'Processos', 51, 1);
INSERT INTO `ttcm_permissions` VALUES (52, 'Processos', 52, 1);
INSERT INTO `ttcm_permissions` VALUES (53, 'Processos', 53, 1);
INSERT INTO `ttcm_permissions` VALUES (54, 'Processos', 54, 1);
INSERT INTO `ttcm_permissions` VALUES (55, 'Administra&ccedil;&atilde;o', 55, 1);
INSERT INTO `ttcm_permissions` VALUES (56, 'Administra&ccedil;&atilde;o', 56, 1);
INSERT INTO `ttcm_permissions` VALUES (57, 'Administra&ccedil;&atilde;o', 57, 1);
INSERT INTO `ttcm_permissions` VALUES (58, 'Administra&ccedil;&atilde;o', 58, 1);
INSERT INTO `ttcm_permissions` VALUES (59, 'Administra&ccedil;&atilde;o', 59, 1);
INSERT INTO `ttcm_permissions` VALUES (60, 'Administra&ccedil;&atilde;o', 60, 1);
INSERT INTO `ttcm_permissions` VALUES (61, 'Administra&ccedil;&atilde;o', 61, 1);
INSERT INTO `ttcm_permissions` VALUES (62, 'Ajuda e Consultoria', 62, 1);
INSERT INTO `ttcm_permissions` VALUES (63, 'Ajuda e Consultoria', 63, 1);
INSERT INTO `ttcm_permissions` VALUES (64, 'Ajuda e Consultoria', 64, 1);
INSERT INTO `ttcm_permissions` VALUES (65, 'Ajuda e Consultoria', 65, 1);
INSERT INTO `ttcm_permissions` VALUES (66, 'Ajuda e Consultoria', 66, 1);
INSERT INTO `ttcm_permissions` VALUES (67, 'Ajuda e Consultoria', 67, 1);
INSERT INTO `ttcm_permissions` VALUES (68, 'Ajuda e Consultoria', 68, 1);
INSERT INTO `ttcm_permissions` VALUES (69, 'Faturas e Pagamentos', 69, 1);
INSERT INTO `ttcm_permissions` VALUES (70, 'Faturas e Pagamentos', 70, 1);
INSERT INTO `ttcm_permissions` VALUES (71, 'Faturas e Pagamentos', 71, 1);
INSERT INTO `ttcm_permissions` VALUES (72, 'Faturas e Pagamentos', 72, 1);
INSERT INTO `ttcm_permissions` VALUES (73, 'Processos', 73, 0);
INSERT INTO `ttcm_permissions` VALUES (74, 'Processos', 74, 0);
INSERT INTO `ttcm_permissions` VALUES (75, 'Clientes', 75, 0);
INSERT INTO `ttcm_permissions` VALUES (76, 'Clientes', 76, 0);
INSERT INTO `ttcm_permissions` VALUES (77, 'Clientes', 77, 0);
INSERT INTO `ttcm_permissions` VALUES (78, 'Messages', 78, 0);
INSERT INTO `ttcm_permissions` VALUES (79, 'Messages', 79, 0);
INSERT INTO `ttcm_permissions` VALUES (80, 'Messages', 80, 0);
INSERT INTO `ttcm_permissions` VALUES (81, 'Clientes', 81, 0);
INSERT INTO `ttcm_permissions` VALUES (82, 'Processos', 82, 0);
INSERT INTO `ttcm_permissions` VALUES (83, 'Processos', 83, 0);
INSERT INTO `ttcm_permissions` VALUES (84, 'Processos', 84, 0);
INSERT INTO `ttcm_permissions` VALUES (85, 'Documentos dos Clientes', 85, 0);
INSERT INTO `ttcm_permissions` VALUES (86, 'Documentos dos Clientes', 86, 0);
INSERT INTO `ttcm_permissions` VALUES (87, 'Ajuda e Consultoria', 87, 0);
INSERT INTO `ttcm_permissions` VALUES (88, 'P&aacute;gina de Contato', 88, 0);
INSERT INTO `ttcm_permissions` VALUES (89, 'Faturas e Pagamentos', 89, 0);
INSERT INTO `ttcm_permissions` VALUES (90, 'Processos', 90, 0);
INSERT INTO `ttcm_permissions` VALUES (91, 'Documentos dos Clientes', 91, 0);
INSERT INTO `ttcm_permissions` VALUES (92, 'Notifica&ccedil;�es por E-mail', 92, 0);
INSERT INTO `ttcm_permissions` VALUES (93, 'Notifica&ccedil;�es por E-mail', 93, 0);
INSERT INTO `ttcm_permissions` VALUES (94, 'Notifica&ccedil;�es por E-mail', 94, 0);
INSERT INTO `ttcm_permissions` VALUES (95, 'Notifica&ccedil;�es por E-mail', 95, 0);
INSERT INTO `ttcm_permissions` VALUES (96, 'Notifica&ccedil;�es por E-mail', 96, 0);
INSERT INTO `ttcm_permissions` VALUES (98, 'Notifica&ccedil;�es por E-mail', 98, 1);
INSERT INTO `ttcm_permissions` VALUES (99, 'Notifica&ccedil;�es por E-mail', 99, 1);
INSERT INTO `ttcm_permissions` VALUES (100, 'Processos', 100, 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `ttcm_project`
-- 

CREATE TABLE `ttcm_project` (
  `project_id` int(10) NOT NULL auto_increment,
  `client_id` int(10) NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  `start` date NOT NULL default '0000-00-00',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `finish` date NOT NULL default '0000-00-00',
  `status` varchar(255) NOT NULL default '',
  `cost` decimal(10,2) NOT NULL default '0.00',
  `milestone` date NOT NULL default '0000-00-00',
  `permissions` text NOT NULL,
  KEY `project_id` (`project_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- 
-- Dumping data for table `ttcm_project`
-- 

INSERT INTO `ttcm_project` VALUES (8, 11, '002.255/2008-7', 'Trata-se da Barragem do Rio do Sono', '2009-08-31', '2009-09-02 17:00:17', '0000-00-00', 'Gabinete do Relator', 0.00, '2009-10-22', '1,11,13,14');
INSERT INTO `ttcm_project` VALUES (7, 10, '001922/2009-5', 'Trata-se de defesa para a PM de Aparecida, no caso Saneago.', '2009-08-28', '2009-09-03 23:43:28', '2009-09-03', 'Finalizado', 1000.00, '2009-09-14', '1,6,11,13,14');

-- --------------------------------------------------------

-- 
-- Table structure for table `ttcm_status`
-- 

CREATE TABLE `ttcm_status` (
  `status_id` int(10) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `type` varchar(255) NOT NULL default '',
  KEY `status_id` (`status_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

-- 
-- Dumping data for table `ttcm_status`
-- 

INSERT INTO `ttcm_status` VALUES (1, 'Em progresso', 'account');
INSERT INTO `ttcm_status` VALUES (2, 'Encerrada', 'account');
INSERT INTO `ttcm_status` VALUES (3, 'Aguardando pagamento', 'account');
INSERT INTO `ttcm_status` VALUES (4, 'Encaminhado para o Fórum', 'project');
INSERT INTO `ttcm_status` VALUES (5, 'Protocolado', 'project');
INSERT INTO `ttcm_status` VALUES (6, 'Aguardando parecer do Juíz', 'project');
INSERT INTO `ttcm_status` VALUES (9, 'Finalizada', 'tasks');
INSERT INTO `ttcm_status` VALUES (10, 'Aguardando resposta', 'tasks');
INSERT INTO `ttcm_status` VALUES (11, 'Em andamento', 'tasks');
INSERT INTO `ttcm_status` VALUES (12, 'Perdida', 'account');
INSERT INTO `ttcm_status` VALUES (13, 'Ganha', 'account');
INSERT INTO `ttcm_status` VALUES (14, 'Não foi iniciada', 'tasks');
INSERT INTO `ttcm_status` VALUES (15, 'Arquivado', 'project');
INSERT INTO `ttcm_status` VALUES (16, 'Não foi iniciado', 'account');
INSERT INTO `ttcm_status` VALUES (17, 'Não foi iniciada', 'project');
INSERT INTO `ttcm_status` VALUES (18, 'Suspenso', 'project');
INSERT INTO `ttcm_status` VALUES (19, 'Gabinete do Relator', 'project');
INSERT INTO `ttcm_status` VALUES (20, 'Aguardando Parecer AFCE', 'project');

-- --------------------------------------------------------

-- 
-- Table structure for table `ttcm_task`
-- 

CREATE TABLE `ttcm_task` (
  `task_id` int(10) NOT NULL auto_increment,
  `project_id` int(10) NOT NULL default '0',
  `client_id` int(10) NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  `start` date NOT NULL default '0000-00-00',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `finish` date NOT NULL default '0000-00-00',
  `milestone` date NOT NULL default '0000-00-00',
  `status` varchar(255) NOT NULL default '',
  `notes` text NOT NULL,
  `assigned` int(10) NOT NULL default '0',
  KEY `task_id` (`task_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- 
-- Dumping data for table `ttcm_task`
-- 

INSERT INTO `ttcm_task` VALUES (5, 8, 11, 'Josi Contato com Cliente', 'Josi ligar para o cliente e avisar que a defesa está pronta no site', '2009-09-02', '2009-09-02 16:35:52', '0000-00-00', '2009-09-03', 'Em andamento', '', 11);

-- --------------------------------------------------------

-- 
-- Table structure for table `ttcm_templates`
-- 

CREATE TABLE `ttcm_templates` (
  `template_id` int(10) NOT NULL auto_increment,
  `template` varchar(255) NOT NULL default '',
  `type` int(3) NOT NULL default '0',
  `subject` varchar(255) NOT NULL default '',
  `htmltext` text NOT NULL,
  PRIMARY KEY  (`template_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- 
-- Dumping data for table `ttcm_templates`
-- 

INSERT INTO `ttcm_templates` VALUES (1, 'Edite o estilo de fontes, cores, tabelas e outros par�metros visuais para todos os e-mails', 1, '', '<style type="text/css"> \r\n<!-- \r\n#divmain { \r\nfont: 10px Verdana, Arial, Helvetica, sans-serif; background: #FFF; margin: 0; padding: 0;\r\n} \r\n#divdata { \r\nfont: 10px Verdana, Arial, Helvetica, sans-serif; line-height: 1.5em; color: #333; padding: 5px 20px 5px 20px; border-bottom: 1px solid #CCC;\r\n}\r\n#divlogo {\r\npadding: 0px 12px 12px 0px; border-bottom: 1px solid #CCC;\r\n} \r\n#divhead { \r\nfont: 14px Verdana, Arial, Helvetica, sans-serif; margin-bottom: 0px; color: #333; font-weight: bold; \r\n} \r\n#divdata a:link { \r\nfont-weight: bold; color: #369; text-decoration: none; \r\n} \r\n#divdata a:visited { \r\nfont-weight: bold; color: #369; text-decoration: none; \r\n} \r\n#divdata a:hover { \r\nfont-weight: bold; color: #369; text-decoration: underline; \r\n} \r\n#divdata a:active { \r\nfont-weight: bold; color: #369; text-decoration: underline; \r\n} \r\n#divitem { \r\nfont: 10px Verdana, Arial, Helvetica, sans-serif; line-height: 1.5em; color: #666; padding: 12px; margin: 12px; background: #eCeCeC; border: #ccc solid 1px;\r\n}\r\n--> </style>');
INSERT INTO `ttcm_templates` VALUES (2, 'Nova atribui��o ao cliente', 0, 'Providencias requeridas', '<div id="divmain">\r\n<div id="divlogo">\r\n[logo]\r\n</div>\r\n\r\n<div id="divdata">\r\n<p id="divhead">Prezado(a) [user name],</p>\r\n<br /><br />\r\n\r\nNovas providências são exigidas para andamendo de seu processo. Verifique na sua �?rea de Acompanhamento Processual junto �  [company].\r\n\r\n<br /><br />\r\n\r\n<div id="divitem">\r\n\r\n<br /><br />\r\n\r\n<strong>Deve ser concluída até:</strong> [deadline]\r\n\r\n</div>\r\n<br />\r\n		\r\nAcesse sua área de Acompanhamento Processual, para ver as providências que dependem de sua ação, usando o link:<br /> \r\n[web path]\r\n		\r\n<br /><br />\r\n</div>\r\n<br />\r\n	\r\n<strong>Cordialmente,</strong>\r\n	\r\n<br />\r\n	\r\n<p>[company]<br />\r\n[website]<br /></p>\r\n</div>');
INSERT INTO `ttcm_templates` VALUES (3, 'Anexado documento ao Cliente', 0, 'Novo documento disponivel: [file title] foi anexado a sua Causa em [company]', '<div id="divmain">\r\n<div id="divlogo">\r\n[logo]\r\n</div>\r\n\r\n<div id="divdata">\r\n<p id="divhead">Prezado(a) [user name],</p>\r\n<br /><br />\r\n\r\nUm novo Documento foi postado e está disponível para você, dentro da sua área de Acompanhamento Processual em [company].\r\n\r\n<br /><br />\r\n\r\n<div id="divitem">\r\n\r\n</div>\r\n<br />\r\n		\r\nVocê pode buscar documentos, acessando sua área de Acompanhamento Processual através do link:<br /> \r\n[web path]\r\n		\r\n<br /><br />\r\n</div>\r\n<br />\r\n	\r\n<strong>Cordialmente,</strong>\r\n	\r\n<br />\r\n	\r\n<p>[company]<br />\r\n</div>');
INSERT INTO `ttcm_templates` VALUES (4, 'Nova mensagem disponivel', 0, '[message title]', '<div id="divmain">\r\n<div id="divlogo">\r\n[logo]\r\n</div>\r\n\r\n<div id="divdata">\r\n<p id="divhead">[message title]</p>\r\n<br /><br />\r\n\r\n<div id="divitem">\r\n<strong>Mensagem:</strong>\r\n\r\n<br /><br />\r\n\r\n[message]\r\n\r\n</div>\r\n<br />\r\n		\r\nResponda esta mensagem clicando no link:\r\n[reply link]\r\n		\r\n<br /><br />\r\n</div>\r\n<br />\r\n	\r\n<strong>Cordialmente,</strong>\r\n	\r\n<br />\r\n	\r\n<p>[company]<br />\r\n[website]<br /></p>\r\n</div>');
INSERT INTO `ttcm_templates` VALUES (5, 'Resposta dispon&iacute;vel', 0, 'Resposta para [message title]', '<div id="divmain">\r\n<div id="divlogo">\r\n[logo]\r\n</div>\r\n\r\n<div id="divdata">\r\n\r\n<div id="divitem">\r\n<strong>Mensagem Respondida:</strong>\r\n\r\n<br /><br />\r\n\r\n[message reply]\r\n\r\n</div>\r\n<br />\r\n		\r\nPara responder esta mensagem, clique no link:\r\n[reply link]\r\n		\r\n<br /><br />\r\n</div>\r\n<br />\r\n	\r\n<strong>Cordialmente,</strong>\r\n	\r\n<br />\r\n	\r\n<p>[company]<br />\r\n[website]<br /></p>\r\n</div>');
INSERT INTO `ttcm_templates` VALUES (6, 'Novo processo iniciado', 0, 'Novo Processo: [project title] foi adicionado por [company]', '<div id="divmain">\r\n<div id="divlogo">\r\n[logo]\r\n</div>\r\n\r\n<div id="divdata">\r\n<p id="divhead">Prezado(a) [user name],</p>\r\n<br /><br />\r\n\r\nUm novo processo a ser acompanhando pelo nosso Sistema de Acompanhamento Processual foi adicionado em [company].<br /><br />\r\n\r\n<div id="divitem">\r\n<strong>Processo:</strong>\r\n\r\n<br /><br />\r\n\r\n[project title]\r\n\r\n<br /><br />\r\n\r\n[project description]\r\n\r\n</div>\r\n<br />\r\n		\r\nVocê pode acompanhar o andamento deste Processo acessando o link:<br /> \r\n[web path]\r\n		\r\n<br /><br />\r\n</div>\r\n<br />\r\n	\r\n<strong>Cordialmente,</strong>\r\n	\r\n<br />\r\n	\r\n<p>[company]<br />\r\n[website]<br /></p>\r\n</div>');
INSERT INTO `ttcm_templates` VALUES (7, 'Novo usu&aacute;rio criado', 0, 'Seus dados para acompanhamento processual', '<div id="divmain">\r\n<div id="divlogo">\r\n[logo]\r\n</div>\r\n\r\n<div id="divdata">\r\n<p id="divhead">Prezado(a) [user name],</p>\r\n<br /><br />\r\n\r\nUma conta de acesso para Acompanhamento Processual junto �  [company] foi criada para Vossa Senhoria. \r\n\r\n<br /><br />\r\n\r\n<div id="divitem">\r\n<strong>Dados de Acesso:</strong>\r\n\r\n<br /><br />\r\n\r\nUSU�?RIO: [username]\r\n\r\n<br /><br />\r\n\r\nSENHA: [password]\r\n\r\n</div>\r\n<br />\r\n		\r\nVossa Senhoria pode acessar a sua área de Acompanhamento Processual por meio do link:<br /> \r\n[web path]\r\n		\r\n<br /><br />\r\n</div>\r\n<br />\r\n	\r\n<strong>Cordialmente,</strong>\r\n	\r\n<br />\r\n	\r\n<p>[company]<br />\r\n[website]<br /></p>\r\n</div>');
INSERT INTO `ttcm_templates` VALUES (8, 'Mudan&ccedil;a de senha do usu&aacute;rio', 0, 'Sua senha de acesso junto a [company] foi alterada', '<div id="divmain">\r\n<div id="divlogo">\r\n[logo]\r\n</div>\r\n\r\n<div id="divdata">\r\n<p id="divhead">Prezado(a) [user name],</p>\r\n<br /><br />\r\n\r\nSua senha de acesso ao Acompanhamento Processual de [company] foi alterada.\r\n\r\n<br /><br />\r\n\r\n<div id="divitem">\r\n<strong>Nova Senha:</strong>\r\n\r\n<br /><br />\r\n\r\n[password]\r\n\r\n</div>\r\n<br />\r\n		\r\nVocê já pode acessar a área de Acompanhamento Processual usando sua nova senha, através do link:<br /> \r\n[web path]\r\n		\r\n<br /><br />\r\n</div>\r\n<br />\r\n	\r\n<strong>Cordialmente,</strong>\r\n	\r\n<br />\r\n	\r\n<p>[company]<br />\r\n[website]<br /></p>\r\n</div>');
INSERT INTO `ttcm_templates` VALUES (9, 'Formul&aacute;rio de Contato', 0, 'Mensagem postada por cliente: [subject]', '<div id="divmain">\r\n<div id="divlogo">\r\n[logo]\r\n</div>\r\n\r\n<div id="divdata">\r\n<p id="divhead">[subject]</p>\r\n<br /><br />\r\n\r\n<div id="divitem">\r\n<strong>Mensagem enviada via Formulário de Contato [sent]</strong>\r\n\r\n<br />\r\n\r\nRelativo ao Processo: [project title]\r\n\r\n<br /><br />\r\n\r\n[message]\r\n\r\n</div>\r\n		\r\n<br /><br />\r\n</div>\r\n<br />\r\n	\r\n<strong>Atenciosamente,</strong>\r\n	\r\n<br />\r\n	\r\n<p>[user name]</p>\r\n</div>');
INSERT INTO `ttcm_templates` VALUES (10, 'Informa��es do usu�rio doram editadas', 0, 'Sua informacoes de Usuario em [company] foram alteradas', '<div id="divmain">\r\n<div id="divlogo">\r\n[logo]\r\n</div>\r\n\r\n<div id="divdata">\r\n<p id="divhead">Prezado(a) [user name],</p>\r\n<br /><br />\r\n\r\nSuas informações de Usuário junto a [company] foram alteradas.\r\n\r\n<br /><br />\r\n\r\n<div id="divitem">\r\n<strong>Novo Nome de Usuário:</strong>\r\n<br />\r\n[user name]\r\n<br /><br />\r\n\r\n<strong>New USU�?RIO:</strong>\r\n<br />\r\n[username]\r\n<br /><br />\r\n\r\n<strong>New AIM:</strong>\r\n<br />\r\n[aim]\r\n<br /><br />\r\n\r\n<strong>New MSN Messenger:</strong>\r\n<br />\r\n[msn]\r\n<br /><br />\r\n\r\n<strong>New Yahoo! Messenger:</strong>\r\n<br />\r\n[yahoo]\r\n<br /><br />\r\n\r\n<strong>New ICQ:</strong>\r\n<br />\r\n[icq]\r\n<br /><br />\r\n\r\n<strong>New Skype:</strong>\r\n<br />\r\n[skype]\r\n<br /><br />\r\n\r\n</div>\r\n<br />\r\n		\r\nYou may log in by using the link below:<br /> \r\n[web path]\r\n		\r\n<br /><br />\r\n</div>\r\n<br />\r\n	\r\n<strong>Thank you,</strong>\r\n	\r\n<br />\r\n	\r\n<p>[company]<br />\r\n[address]<br />\r\n[city], [state] [zip]<br />\r\n[phone]<br />\r\n[alternate phone]<br />\r\n[website]<br /></p>\r\n</div>');
INSERT INTO `ttcm_templates` VALUES (11, 'Cliente enviou documento', 0, '[client name] enviou um documento com titulo: [file title]', '<div id="divmain">\r\n<div id="divlogo">\r\n[logo]\r\n</div>\r\n\r\n<div id="divdata">\r\n<p id="divhead">Prezado(a) [user name],</p>\r\n<br /><br />\r\n\r\n[client name] enviou um novo documento na �?rea de Cliente do Acompanhamento Processual.\r\n\r\n<br /><br />\r\n\r\n<div id="divitem">\r\n<strong>Documento Anexado: [file title]</strong>\r\n<br/>\r\npara o Processo: [project title]\r\n\r\n<br /><br />\r\n\r\n[file link]\r\n\r\n</div>\r\n<br />\r\n		\r\nVocê pode ver e baixar este e outros documentos, acessando sua conta através do link:<br /> \r\n[web path]\r\n		\r\n<br /><br />\r\n</div>\r\n<br />\r\n	\r\n<strong>Cordialmente,</strong>\r\n	\r\n<br />\r\n	\r\n<p>[company]<br />\r\n[address]<br />\r\n[city], [state] [zip]<br />\r\n[phone]<br />\r\n[alternate phone]<br />\r\n[website]<br /></p>\r\n</div>');

-- --------------------------------------------------------

-- 
-- Table structure for table `ttcm_todo`
-- 

CREATE TABLE `ttcm_todo` (
  `todo_id` int(10) NOT NULL auto_increment,
  `client_id` int(10) NOT NULL default '0',
  `project_id` int(10) NOT NULL default '0',
  `item` text NOT NULL,
  `deadline` date NOT NULL default '0000-00-00',
  `done` tinyint(2) NOT NULL default '0',
  `link` varchar(255) NOT NULL default '',
  KEY `todo_id` (`todo_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- 
-- Dumping data for table `ttcm_todo`
-- 

INSERT INTO `ttcm_todo` VALUES (3, 11, 8, 'Por favor envie o Relatório Fotográfico até sexta-feira.', '2009-08-31', 0, '');
INSERT INTO `ttcm_todo` VALUES (4, 11, 8, 'Envie o Laudo Técnico', '2009-08-31', 1, '');
INSERT INTO `ttcm_todo` VALUES (5, 11, 8, 'confirmar os dados da obra', '2009-09-03', 0, '');

-- --------------------------------------------------------

-- 
-- Table structure for table `ttcm_topics`
-- 

CREATE TABLE `ttcm_topics` (
  `topic_id` int(8) NOT NULL auto_increment,
  `cat_id` int(5) NOT NULL default '0',
  `topic` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  `views` int(25) NOT NULL default '0',
  KEY `topic_id` (`topic_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- 
-- Dumping data for table `ttcm_topics`
-- 

INSERT INTO `ttcm_topics` VALUES (2, 2, ' Documentos necessários para a ação revisional', 'O contrato, as faturas e os extratos são documentos importantíssimos, principalmente para o ajuizamento da ação revisional pois trazem a prova do valor financiado, das parcelas a serem pagas, das multas, da taxa de juros utilizada e outros encargos que são cobrados. Portanto, se a Instituição Financeira se negar a lhe entregar o contrato ou demorar na entrega deste, você pode buscar na Justiça uma solução, através de uma ação para exibição destes documentos, na qual o juiz ordena �  Instituição que mostre os documentos.\r\n\r\nEste tipo de ação também serve para que os consumidores tenham acesso aos contratos, pois várias vezes recebem produtos como cartões de crédito ou fazem empréstimos sem que tenham conhecimento das cláusulas do contrato ao qual aderiram.\r\n\r\nFique atento, se a instituição se negar a entregar os documentos ou demorar na entrega, procure um advogado de sua confiança e busque a apresentação destes documentos através do Judiciário. É um direito do consumidor garantido por lei!', 0);
INSERT INTO `ttcm_topics` VALUES (3, 2, 'Defesa do consumidor em processo de execução', 'As execuções muitas vezes não traduzem o real valor devido, pois decorrem de contratos aos quais houve acréscimo de juros e outros encargos considerados abusivos e ilegais, pois decorrentes de uma relação totalmente desiquilibrada, a qual é excessivamente onerosa para o consumidor e, em contra-partida, é extremamente benéfica para a Instituição Financeira.\r\n\r\nPortanto, esta execução é passível de defesa judicial, e é muito importante que esta defesa seja feita por um advogado especializado e de sua confiança, buscando assim evitar a retirada indevida ou injusta de bens do executado.\r\n\r\nA ação revisional do contrato que está sendo recalculado, com o depósito judicial dos valores que o consumidor entende devidos, muitas vezes suspende a execução até o julgamento final.\r\n\r\nE durante o andamento da ação, sempre é aconselhável procurar o credor para tentar fazer um acordo que seja vantajosos para você.', 1);
INSERT INTO `ttcm_topics` VALUES (5, 3, 'Nova jurisprudência no Tribunal', 'a partir do Acórdão n.352/2009, houve mudança na interpretação dada aos dispositivos.', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `ttcm_user`
-- 

CREATE TABLE `ttcm_user` (
  `id` int(10) NOT NULL auto_increment,
  `client_id` int(10) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `username` varchar(255) NOT NULL default '',
  `password` varchar(255) NOT NULL default '',
  `address1` varchar(255) NOT NULL default '',
  `address2` varchar(255) NOT NULL default '',
  `city` varchar(255) NOT NULL default '',
  `state` varchar(255) NOT NULL default '',
  `zip` varchar(15) NOT NULL default '',
  `country` varchar(255) NOT NULL default '',
  `phone` varchar(50) NOT NULL default '',
  `phone_alt` varchar(50) NOT NULL default '',
  `fax` varchar(50) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `aim` varchar(255) NOT NULL default '',
  `icq` varchar(255) NOT NULL default '',
  `msn` varchar(255) NOT NULL default '',
  `yahoo` varchar(255) NOT NULL default '',
  `skype` varchar(255) NOT NULL default '',
  `type` varchar(255) NOT NULL default '',
  `last_login` datetime NOT NULL default '0000-00-00 00:00:00',
  `permissions` text NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

-- 
-- Dumping data for table `ttcm_user`
-- 

INSERT INTO `ttcm_user` VALUES (13, 11, 'Usuário de Testes', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Seu endereço', '', 'Seu bairro', 'Sua cidade', 'Seu CEP', 'Seu estado', 'Seu telefone', 'Seu celular', 'Seu fax', 'seuemail@dominio', '', '', '', '', '', '1', '2009-09-04 02:43:11', '7,8,5,6,57,56,58,55,60,61,59,19,20,18,15,16,17,14,30,29,32,33,31,37,38,36,35,34,42,41,26,27,28,25,40,39,70,71,72,69,12,13,11,9,10,98,99,44,45,43,22,23,24,21,47,48,46,2,3,4,1,100,54,53,50,51,52,49,62,64,65,63,66,67,68,116,113,118,117,115,114,101,102,103,104,110,111,112,109,106,107,108,105');

-- --------------------------------------------------------

-- 
-- Table structure for table `ttcm_usertypes`
-- 

CREATE TABLE `ttcm_usertypes` (
  `usertype_id` int(5) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  `permissions` varchar(255) NOT NULL default '',
  `type` tinyint(2) NOT NULL default '0',
  KEY `usertype_id` (`usertype_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- 
-- Dumping data for table `ttcm_usertypes`
-- 

INSERT INTO `ttcm_usertypes` VALUES (1, 'Super Admin', 'Super Admin has the permission over everything', '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,98,99,100,101,102,103,104,105,106,107,108,109,11', 0);
INSERT INTO `ttcm_usertypes` VALUES (4, 'Cliente', 'Tipo de usuário com permissões de acesso para Clientes do escritório', '89,85,91,75,81,88,93,94,95,92,87,79,80,78,83,82,73,74', 0);
INSERT INTO `ttcm_usertypes` VALUES (6, 'Advogado', 'Permissões para usuários que são advogados do escritório', '7,8,5,6,57,56,58,55,60,61,59,62,64,65,63,66,67,68,19,20,18,15,16,17,14,30,29,32,33,31,37,38,36,35,34,42,41,26,27,28,25,39,40,70,71,72,69,12,13,11,9,10,98,99,44,45,43,22,23,24,21,47,48,46,2,3,4,1,100,54,53,50,51,52,49', 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `ttcm_websites`
-- 

CREATE TABLE `ttcm_websites` (
  `web_id` int(10) NOT NULL auto_increment,
  `client_id` int(10) NOT NULL default '0',
  `website` varchar(255) NOT NULL default '',
  KEY `web_id` (`web_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `ttcm_websites`
-- 

