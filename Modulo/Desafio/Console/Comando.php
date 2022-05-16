<?php
namespace Modulo\Desafio\Console;
 
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

class Comando extends Command
{
    const COLOR = 'Color';
    const STORE = 'Store';

    protected $_resource;
    protected $_storeManager;

    public function __construct(
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->_resource = $resource;
        $this->_storeManager = $storeManager;
        parent::__construct();
    }

    protected function configure()
    {
        $commandoptions = [
            new InputOption(
                self::COLOR, 
                null, 
                InputOption::VALUE_REQUIRED, 
                'Color'
            ),
            new InputOption(
                self::STORE, 
                null, 
                InputOption::VALUE_REQUIRED, 
                'Store'
            )
        ];

        $this->setName('modulo:color-change');
        $this->setDescription('Color change by store-view');
        $this->setDefinition($commandoptions);
        parent::configure();
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $color = $input->getOption(self::COLOR);
        $store = intval($input->getOption(self::STORE));

        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/comando.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);

        $stores_id = array();
        $achou_store=false;

        foreach($this->_storeManager->getStores() as $key => $store_item){
            $stores_id[] = $key;
            if($key == $store){
                $achou_store = true;
            }
        }

        if(!$achou_store){
            $output->writeln("Loja não encontrada!");
            return false;
        }

        $sql="SELECT * FROM table_store_color where store_id =".intval($store);
        $connection = $this->_resource->getConnection();
        $connection->query($sql);
        $result = $connection->fetchAll($sql);

        if(!$result){
            $sql="
                INSERT INTO table_store_color(store_id, color) 
                VALUES
                (
                    ".$store.",
                    '".$color."'
                );"
            ;
        }else{
            $sql="UPDATE table_store_color SET color='".$color."' WHERE store_id=".$store.";";
        }
        $connection->query($sql);
        
        $output->writeln("Color: ".$color);
        $output->writeln("Store: ".$store);

        // if ($customername = $input->getOption(self::CUSTOMERNAME))
        // {
        //     $output->writeln("Hi ".$customername);
        // }else{
        //     $output->writeln("Hi Customer");
        // }
    }
}