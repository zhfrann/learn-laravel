<?php

namespace Tests\Feature;

use App\Data\Bar;
use App\Data\Foo;
use App\Data\Person;
use App\Service\HelloServiceIndonesia;
use App\Service\IHelloService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServiceContainerTest extends TestCase
{
    public function testCreateDependency()
    {
        $foo = $this->app->make(Foo::class); //new Foo()
        $foo2 = $this->app->make(Foo::class); //new Foo()

        self::assertEquals("Foo", $foo->foo());
        self::assertEquals("Foo", $foo2->foo());
        self::assertNotSame($foo, $foo2);
    }

    public function testBind()
    {
        // $person = $this->app->make(Person::class); //new Person()
        // self::assertNotNull($person); //! BindingResolutionException, Person firstname & lastname is null.

        // app->bind(string $abstract, closure $func) will define how to create the object using app->make()
        $this->app->bind(Person::class, function ($app) {
            return new Person("John", "Doe");
        });

        $person1 = $this->app->make(Person::class); //new Person("John", "Doe")
        $person2 = $this->app->make(Person::class); //new Person("John", "Doe")

        self::assertEquals("John", $person1->firstName);
        self::assertEquals("John", $person2->firstName);
        self::assertNotSame($person1, $person2);
    }

    public function testSingleton()
    {
        $this->app->singleton(Person::class, function ($app) {
            return new Person("John", "Doe");
        });

        $person1 = $this->app->make(Person::class); //new Person("John", "Doe"); if not exists
        $person2 = $this->app->make(Person::class); //return existing
        $person3 = $this->app->make(Person::class); //return existing

        self::assertEquals("John", $person1->firstName);
        self::assertEquals("John", $person2->firstName);
        self::assertSame($person1, $person2);
    }

    public function testInstance()
    {
        $person = new Person("John", "Doe");
        $this->app->instance(Person::class, $person);

        $person1 = $this->app->make(Person::class); // $person
        $person2 = $this->app->make(Person::class); // $person
        $person3 = $this->app->make(Person::class); // $person

        self::assertEquals("John", $person1->firstName);
        self::assertEquals("John", $person2->firstName);
        self::assertSame($person1, $person2);
    }

    public function testDependencyInjection()
    {
        $foo = $this->app->make(Foo::class); // new Foo()
        $bar1 = $this->app->make(Bar::class); // new Bar(new Foo()) //* Laravel automatically create Foo instance for Bar(\App\Data\Foo $foo)
        $bar2 = $this->app->make(Bar::class); // new Bar(new Foo()) //* Laravel automatically create Foo instance for Bar(\App\Data\Foo $foo)

        self::assertEquals("Foo and Bar", $bar1->bar());
        self::assertNotSame($foo, $bar1->foo); //* $foo from line 73 is different with $bar1->foo that created by laravel using ServiceContainer
        self::assertNotSame($bar1->foo, $bar2->foo); //* $bar1->foo is different with $bar2->foo that created by laravel using ServiceContainer
    }

    public function testDependencyInjectionWithSingleton()
    {
        $this->app->singleton(Foo::class, function ($app) {
            return new Foo();
        });

        $foo = $this->app->make(Foo::class); // new Foo()
        $bar1 = $this->app->make(Bar::class); // new Bar(\App\Data\Foo $foo) //* this $foo is taken from singleton() from line 82
        $bar2 = $this->app->make(Bar::class); // new Bar(\App\Data\Foo $foo) //* this $foo is taken from singleton() from line 82

        self::assertEquals("Foo and Bar", $bar1->bar());
        self::assertSame($foo, $bar1->foo);
        self::assertSame($bar1->foo, $bar2->foo);
    }

    public function testDependencyInjectionInClosure()
    {
        $this->app->singleton(Foo::class, function ($app) {
            return new Foo();
        });

        $this->app->singleton(Bar::class, function ($app) {
            $foo = $app->make(Foo::class);
            return new Bar($foo);
        });

        $foo = $this->app->make(Foo::class);
        $bar1 = $this->app->make(Bar::class);
        $bar2 = $this->app->make(Bar::class);

        self::assertSame($bar1, $bar2);
        self::assertSame($foo, $bar1->foo);
        self::assertSame($foo, $bar2->foo);
    }

    public function testIHelloService()
    {
        $this->app->bind(IHelloService::class, HelloServiceIndonesia::class);
        // or
        $this->app->bind(IHelloService::class, function ($app) {
            return new HelloServiceIndonesia();
        });

        // or using
        // $this->app->singleton(IHelloService::class, HelloServiceIndonesia::class);
        // or
        // $this->app->singleton(IHelloService::class, function ($app) {
        //     return new HelloServiceIndonesia();
        // });

        $helloService = $this->app->make(IHelloService::class);
        self::assertEquals("Halo John", $helloService->hello("John"));
    }
}
