<?php
/**
 * @category    Halex
 * @package     Halex\VideoWysiwyg
 * @author      Aleksejs Prjahins <aleksejs.prjahins@gmail.com>
 * @license     http://opensource.org/licenses/OSL-3.0 The Open Software License 3.0 (OSL-3.0)
 */

declare(strict_types=1);

namespace Halex\VideoWysiwyg\Plugin\Magento\MediaGalleryUi\Ui\Component\Listing\Columns;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\MediaGalleryUi\Ui\Component\Listing\Columns\Url as SourceUrl;
use Magento\Store\Model\StoreManagerInterface;

class Url
{
    /**
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $storeManager;

    /**
     * @var array
     */
    const VIDEO_EXTENSIONS = ['mp4', 'mov'];

    /**
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        StoreManagerInterface $storeManager,
    ) {
        $this->storeManager = $storeManager;
    }

    /**
     * After Prepare Data Source
     *
     * @param SourceUrl $subject
     * @param $result
     *
     * @return mixed
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterPrepareDataSource(SourceUrl $subject, $result)
    {
        try {
            foreach ($result['data']['items'] as &$item) {
                if (in_array(strtolower($item['content_type'] ?: ''), self::VIDEO_EXTENSIONS)) {
                    $item['thumbnail_url'] =
                        $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA)
                        . 'video.png';
                }
            }

            return $result;
        } catch (NoSuchEntityException $exception) {
            return $result;
        }
    }
}
