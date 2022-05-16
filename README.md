# Desafio
Desafio Magento 2

Modulo com custom cli para mudar cor de buttons a partir de uma store_view.

1 - Instalação
	Para instalar o módulo, basta apenas por o diretório dentro da pasta app/code/.
	Rodar os comandos:
		- bin/magento indexer:reindex;
		- php bin/magento setup:di:compile;
		- php bin/magento setup:upgrade;
		- php bin/magento setup:static-content:deploy en_US pt_BR -f;
		- php bin/magento cache:clean;
		- php bin/magento cache:flush;
    
2 - Processo
	- Criei o CLI com a seguinte forma: 
		php bin/magento modulo:color-change --Color="000000" --Store="1"

	- Criei uma table no BD a partir de um db_schema.xml, para que eu pudesse salvar a  cor atual 
	da store_view, e para que pudesse lê-la a partir de um JS.

	- Criei uma chamada Rest API para que pudesse pegar as informações salvas no BD a partir do CLI
	em um arquivo JS que rodasse para todas as páginas da plataforma.
