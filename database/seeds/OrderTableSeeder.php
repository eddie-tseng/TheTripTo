<?php

use Illuminate\Database\Seeder;
use App\Entities\Order;
use App\Entities\Tourist;
use App\Entities\Comment;
use App\Repositories\TourRepository;
use App\Repositories\CommentRepository;


class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Order::class, 300)
            ->create()
            ->each( function ($order) {
                $tourRepository = new TourRepository();
                $commentRepository = new CommentRepository();
                //fake tourist information
                $order->tourists()->saveMany(
                    factory(Tourist::class, $order->quantity)
                    ->make()
                );

                //update inventory and sold
                $tour = $tourRepository->filterByField('id', '=', $order->tour_id)->get()->first();
                $inventory = $tour->inventory - $order->quantity;
                $sold = $tour->sold + $order->quantity;

                if($inventory>=0){
                    $tour->update(['sold' => $sold , 'inventory' => $inventory]);
                }
                else {
                    $this->command->comment("Tour:" + $tour->id + "sold out!!!");
                }

                //fake comment
                $comment = factory(Comment::class, 1)->make();
                $order->comment()->save($comment->first());

                //update tour rating
                $raitings = $commentRepository->filterByField('order_id', '=',  $order->id)->getColumn('rating');
                $tour->update(['rating' => round($raitings->avg())]);
            });
    }
}
