<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number', 50)->unique();
            $table->string('customer_name', 200);
            $table->string('customer_number', 50)->nullable();
            $table->string('rfc', 20)->nullable();
            $table->text('fiscal_address')->nullable();
            $table->string('fiscal_email', 150)->nullable();
            $table->text('delivery_address')->nullable();
            $table->text('notes')->nullable();
            $table->dateTime('order_date');
            $table->enum('status', ['ordered', 'in_process', 'in_route', 'delivered'])->default('ordered');
            $table->tinyInteger('deleted')->default(0);
            $table->foreignId('created_by')->constrained('users')->onDelete('restrict');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
