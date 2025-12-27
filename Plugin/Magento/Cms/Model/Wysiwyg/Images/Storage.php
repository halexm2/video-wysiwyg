<?php
/**
 * @category    Halex
 * @package     Halex\VideoWysiwyg
 * @author      Aleksejs Prjahins <aleksejs.prjahins@gmail.com>
 * @license     http://opensource.org/licenses/OSL-3.0 The Open Software License 3.0 (OSL-3.0)
 */

declare(strict_types=1);

namespace Halex\VideoWysiwyg\Plugin\Magento\Cms\Model\Wysiwyg\Images;

use Halex\VideoWysiwyg\Plugin\Magento\MediaGalleryUi\Ui\Component\Listing\Columns\Url;
use Magento\Cms\Model\Wysiwyg\Images\Storage as SourceStorage;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\Module\Dir;
use Magento\Framework\Module\Dir\Reader;

/**
 * Class Storage
 */
class Storage
{
    /**
     * @var Filesystem
     */
    private Filesystem $filesystem;

    /**
     * @var Reader
     */
    private Reader $moduleReader;

    /**
     * @param Reader $moduleReader
     * @param Filesystem $filesystem
     */
    public function __construct(
        Reader     $moduleReader,
        Filesystem $filesystem
    ) {
        $this->filesystem = $filesystem;
        $this->moduleReader = $moduleReader;
    }

    /**
     * @param SourceStorage $subject
     * @param $source
     * @param $keepRatio
     *
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeResizeFile(
        SourceStorage $subject,
                      $source,
                      $keepRatio = true
    ): array {
        $sourceInfo = explode('.', $source);
        $fileExtension = end($sourceInfo);

        if (in_array(strtolower($fileExtension), Url::VIDEO_EXTENSIONS)) {
            $mediaPath = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath()
                . 'video.png';

            if (!file_exists($mediaPath)) {
                copy(
                    $this->moduleReader->getModuleDir(
                        Dir::MODULE_VIEW_DIR,
                        'Halex_VideoWysiwyg'
                    ) . '/adminhtml/web/images/video.png',
                    $mediaPath
                );
            }

            $source = $mediaPath;
        }

        return [$source, $keepRatio];
    }
}
