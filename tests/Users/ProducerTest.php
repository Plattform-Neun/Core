<?php

namespace Marktstand\Tests\Users;

use Illuminate\Support\Facades\Event;
use Marktstand\Events\UserVerified;
use Marktstand\Events\VerificationRequest;
use Marktstand\Payment\BankAccount;
use Marktstand\Product\Product;
use Marktstand\Tests\TestCase;
use Marktstand\Users\Producer;

class ProducerTest extends TestCase
{
    /** @test */
    public function it_may_has_many_products()
    {
        $producer = factory(Producer::class)->create();
        factory(Product::class, 5)->create(['producer_id' => $producer->id]);

        $this->assertCount(5, $producer->products);
    }

    /** @test */
    public function it_may_has_many_bank_accounts()
    {
        $producer = factory(Producer::class)->create();
        factory(BankAccount::class)->create([
            'user_id' => $producer->id,
            'user_type' => 'producer'
        ]);

        factory(BankAccount::class)->create([
            'user_id' => $producer->id,
            'user_type' => 'producer'
        ]);

        $this->assertCount(2, $producer->bankAccounts);
    }

    /** @test */
    public function it_can_be_verified()
    {
        Event::fake();

        $producer = factory(Producer::class)->create([
            'verified_at' => null
        ]);

        $this->assertFalse($producer->isVerified());

        $producer->verify();

        $this->assertTrue($producer->isVerified());
        Event::assertDispatched(UserVerified::class);
    }

    /** @test */
    public function it_may_requests_verification()
    {
        Event::fake();

        $producer = factory(Producer::class)->create();
        $producer->requestVerification();

        Event::assertDispatched(VerificationRequest::class);
    }
}
