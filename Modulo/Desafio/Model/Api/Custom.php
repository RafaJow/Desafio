<?php
 
namespace Modulo\Desafio\Model\Api;
 
use Psr\Log\LoggerInterface;
 
class Custom
{
    protected $logger;
    protected $_storeManager;
    protected $_resource;

    public function __construct(
        LoggerInterface $logger,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    )
    {
        $this->_resource = $resource;
        $this->_storeManager = $storeManager;
        $this->logger = $logger;
    }
 
    /**
     * @inheritdoc
     */
 
    public function getStore()
    {
        $response = ['success' => false];
 
        try {
            $id = $this->_storeManager->getStore()->getId();

            $sql="SELECT color FROM table_store_color where store_id =".intval($id);
            $connection = $this->_resource->getConnection();
            $connection->query($sql);
            $result = $connection->fetchAll($sql);

            $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/api.log');
            $logger = new \Zend\Log\Logger();
            $logger->addWriter($writer);

            $color=$result[0]['color'];
            $logger->info("color: ".$color);

            $response = ['success' => true, 'store' => $id, 'color' => $color];
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => $e->getMessage()];
            $this->logger->info($e->getMessage());
        }
        $returnArray = json_encode($response);
        return $returnArray; 
    }

}