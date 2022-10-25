<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Terminal;

class POS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'terminal:pos
    {--scanorder= : Scan order for processing (i.e. AAAAA, ABCD, etc...) }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct() {
		$this->terminal = new Terminal;
        $this->scans = [];
        $this->total = 0;
		parent::__construct();
	}

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        if ( !$this->option('scanorder') ) {
            print "\nError: You must input your scan order\n\n";
            exit();
        }

        $scanorder = str_split($this->option('scanorder'));

        foreach( $scanorder as $scan ) {
            $this->scanArray($scan);
        }

        print "SKU |\tQTY |\tSUBTOTAL\n";

        $totalArray = $this->total();

        print "----------------------\n";
        print "Subtotal: $" . number_format($totalArray['sub_total']/100, 2, '.', ',') . "\n";
        print "Tax: $" . number_format($totalArray['tax']/100, 2, '.', ',') . "\n";
        print "Total: $" . number_format($totalArray['total']/100, 2, '.', ',') . "\n";

        return Command::SUCCESS;
    }

    public function scanArray($sku)
    {
        # code...
        $scan = $this->terminal->scan($sku);
        if ( !$scan ) {
            return false;
        }

        if ( isset($this->scans[$scan->id]) ) {
            $this->scans[$scan->id]['qty'] = $this->scans[$scan->id]['qty'] + 1;
        } else {
            $this->scans[$scan->id] = [
                'sku' => $scan->code,
                'price' => $scan->price,
                'id' => $scan->id,
                'qty' => 1,
            ];
        }

        return;
    }

    public function total()
    {
        # code...
        foreach($this->scans as $scan) {

            $promo = $this->terminal->promo($scan['id']);

            if ($promo) {
                if ( $promo->ref_product_id == NULL ) {
                    if ( $scan['qty'] >= $promo->product_qty ) {

                        $rem = $scan['qty'] % $promo->product_qty;
                        $newqty = ($scan['qty']- $rem) / $promo->product_qty;

                        $newprice = ($newqty * $promo->new_price) + ($rem * $scan['price']);

                        $this->scans[$scan['id']]['price'] = $newprice;
                        $subTotalScan = $newprice;
                    } else {
                        $subTotalScan = $scan['price'] * $scan['qty'];
                    }
                } else {

                    if ( isset($this->scans[$promo->ref_product_id]) ) {

                        if ( $scan['qty'] >= $promo->product_qty && $this->scans[$promo->ref_product_id]['qty'] >= $promo->ref_product_qty ) {

                            $refqty = $this->scans[$promo->ref_product_id]['qty'] / $promo->ref_product_qty;
                            $refqty = round($refqty, 0);

                            $rem = $scan['qty'] % $promo->product_qty;
                            $newqty = ($scan['qty']- $rem) / $promo->product_qty;

                            $rem2 = $refqty % $newqty;
                            $newqty2 = ($newqty - $rem2) / $promo->product_qty;

                            $newprice = ($newqty2 * $promo->new_price) + ($rem2 * $scan['price']);

                            
                        }


                        $subTotalScan = $newprice;
                    }

                }
            } else {
                $subTotalScan = $scan['price'] * $scan['qty'];
            }

            print $scan['sku'] . " |\t" . $scan['qty'] . " |\t$" . number_format($subTotalScan/100, 2, '.', ',') . "\n";

            $this->total = $this->total + $subTotalScan;
        }

        $totalArray = [
            'sub_total' => $this->total,
            'total' => $this->total + ( $this->total * 0.1 ),
            'tax' => $this->total * 0.1,
        ];

        return $totalArray;
    }
}
