truncate ordem_producao;
truncate fluxo;
truncate fluxo_bancos;
truncate ordem_separacao;
truncate estoque;
update produtos set estoque_atual = 0 ;

select * from ordem_separacao;
select * from ordem_producao;
select * from estoque;
select codigo, estoque_atual from produtos WHERE codigo like '%STK 065%';

select * from pedidos_itens order by id desc;
select * from pedidos order by id desc;


select * from erp.menus;

insert into erp.menus (`id`, `id_menus`, `nome`, `link`, `alt`, `data_cad`, `ordem`, `icone`) 
 select `id`, `id_menus`, `nome`, `link`, `alt`, `data_cad`, `ordem`, `icone` from stoik.menus;

select * from erp.menus;
select * from erp.permissoes_niveis;
select * from stoik.menus;


INSERT INTO `menus` (`id`, `id_menus`, `nome`, `link`, `alt`, `data_cad`, `ordem`) VALUES ('67', '18', 'Produtos', '#', 'Produtos', '2015-06-25', '1');