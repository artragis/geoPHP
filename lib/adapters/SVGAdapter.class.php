<?php
namespace danoh_geo\Adapter;
use danoh_geo\Geometry;
/*
 * (c) Camptocamp <info@camptocamp.com>
 * (c) Patrick Hayes
 *
 * This code is open-source and licenced under the Modified BSD License.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * SVGAdapter class : a SVG reader/writer.
 * 
 * Note that it will always return a GeoJSON geometry. This
 * means that if you pass it a feature, it will return the
 * geometry of that feature strip everything else.
 * @author artragis
 * @version 1
 */
class SVGAdapter extends \danoh_geo\Adapter\GeoAdapter{
    public function read($xmlString){
        
    }
    public function write(Geometry\Geometry $geometry){
        
    }
}

?>
