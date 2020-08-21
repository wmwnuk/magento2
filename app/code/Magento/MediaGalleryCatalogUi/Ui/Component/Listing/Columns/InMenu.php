<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\MediaGalleryCatalogUi\Ui\Component\Listing\Columns;

use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class InMenu column for Category grid
 */
class InMenu extends Column
{
    /**
     * Prepare data source.
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item[$fieldName]) && $item[$fieldName] == 1) {
                    $item[$fieldName] = '<span class="1">Yes</span>';
                } else {
                    $item[$fieldName] = '<span class="0">No</span>';
                }
            }
        }

        return $dataSource;
    }
}
