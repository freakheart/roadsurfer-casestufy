<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Category;
use App\Entity\Customer;
use App\Entity\Offer;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use App\Entity\Station;
use App\Entity\User;
use DateInterval;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Faker\Generator;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\Date;

class AppFixtures extends Fixture
{
    private UserPasswordEncoderInterface $passwordEncoder;
    private Generator $generator;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, Generator $generator)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->generator = $generator;
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadUsers($manager);
        $this->loadStations($manager);
        $this->loadCategories($manager);
        $this->loadProducts($manager);
        $this->loadCustomers($manager);
        $this->loadOffers($manager);
        $this->loadOrders($manager);
    }

    private function loadUsers(ObjectManager $manager): void
    {
        foreach ($this->getUserData() as [$firstName, $lastName, $username, $password, $email, $roles]) {
            $user = new User();
            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $user->setUsername($username);
            $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
            $user->setEmail($email);
            $user->setRoles($roles);

            $manager->persist($user);
            $this->addReference($username, $user);
        }

        $manager->flush();
    }

    private function loadStations(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; ++$i) {
            $station = new Station();
            $station->setName($this->generator->city);

            $manager->persist($station);
            $this->addReference('station-'.$i, $station);
        }

        /*foreach ($this->getStationData() as $index => $name) {
            $station = new Station();
            $station->setName($name);

            $manager->persist($station);
            $this->addReference('station-'.$index, $station);
        }*/

        $manager->flush();
    }

    private function loadCategories(ObjectManager $manager): void
    {
        foreach ($this->getCategoriesData() as $index => $name) {
            $category = new Category();
            $category->setName($name);

            $manager->persist($category);
            $this->addReference('category-'.$index, $category);
        }

        $manager->flush();
    }

    private function loadProducts(ObjectManager $manager): void
    {
        /*foreach ($this->getProductsData() as $key => [$name, $shortDescription, $description, $price, $stock, $category]) {
            $product = new Product();
            $product->setName($name);
            $product->setShortDescription($shortDescription);
            $product->setDescription($description);
            $product->setPrice($price);
            $product->addCategory($category);

            $manager->persist($product);
            $this->addReference('product-'.$key, $product);
        }*/

        for ($i = 0; $i < 20; ++$i) {
            $product = new Product();
            $product->setName($this->generator->text(10));
            $product->setShortDescription($this->generator->text(100));
            $product->setDescription($this->generator->paragraph);
            $product->setPrice($this->generator->randomFloat());
            $product->addCategory($this->getReference('category-'.$this->generator->numberBetween(0, 5)));

            $manager->persist($product);
            $this->addReference('product-'.$i, $product);
        }

        $manager->flush();
    }

    private function loadCustomers(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; ++$i) {
            $gender = $this->generator->randomElement(['male', 'female']);

            $address = new Address();
            $address->setSalutation($this->generator->title($gender));
            $address->setFirstName($this->generator->firstName($gender));
            $address->setLastName($this->generator->lastName);
            $address->setStreet($this->generator->streetName);
            $address->setPostcode($this->generator->postcode);
            $address->setCity($this->generator->city);
            $address->setCountry($this->generator->country);
            $address->setPhoneNumber($this->generator->phoneNumber);
            $address->setCompany($this->generator->company);

            $customer = new Customer();
            $customer->setSalutation($this->generator->title($gender));
            $customer->setFirstName($this->generator->firstName($gender));
            $customer->setLastName($this->generator->lastName);
            $customer->setEmail($this->generator->safeEmail);
            $customer->addAddress($address);

            $manager->persist($customer);
            $this->addReference('customer-'.$i, $customer);
        }

        $manager->flush();
    }

    private function loadOffers(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; ++$i) {
            $offer = new Offer();
            $offer->setStock($this->generator->numberBetween(100, 200));
            $offer->setPrice($this->generator->randomFloat());
            $offer->setProduct($this->getReference('product-'.$i));
            $offer->setStation($this->getReference('station-'.$i));

            $manager->persist($offer);
            $this->addReference('offer-'.$i, $offer);
        }
        $manager->flush();
    }

    /**
     * @throws Exception
     */
    private function loadOrders(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; ++$i) {
            $product = $this->getReference('product-'.$i);
            $orderItem = new OrderItem();
            $orderItem->setProduct($product);
            $orderItem->setPrice($product->getPrice());
            $orderItem->setName($product->getName());
            $orderItem->setQuantity($this->generator->numberBetween(1, 50));

            $pickupDate = $this->generator->dateTimeBetween('now', '+5 days');
            $returnDate = $this->generator->dateTimeBetween('+6 days', '+20 days');

            $order = new Order();
            $order->setCustomer($this->getReference('customer-'.$i));
            $order->setPickupStation($this->getReference('station-'.$i));
            $order->setReturnStation($this->getReference('station-'.$i));
            $order->setCustomer($this->getReference('customer-'.$i));
            $order->setScheduledPickupDate($pickupDate->setTime(0, 0));
            $order->setScheduledReturnDate($returnDate->setTime(0, 0));
            $order->setGrandTotal($product->getPrice());
            $order->addItem($orderItem);

            $manager->persist($order);
            $this->addReference('order-'.$i, $order);
        }

        $manager->flush();
    }

    private function getUserData(): array
    {
        return [
            // $userData = [$firstname, $lastname, $username, $password, $email, $roles];
            ['Admin', 'User', 'admin', 'admin', 'admin@roadsurfer.com', ['ROLE_ADMIN']],
            ['Kamikaze', 'Bubblegum Warrior', 'kamikaze', 'kitten', 'kamikaze@roadsurfer.com', ['ROLE_USER']],
            ['Agreeable', 'Anaconda', 'anaconda', 'anaconda', 'anaconda@roadsurfer.com', ['ROLE_USER']],
            ['Neurotic', 'Jackhammer Detective', 'detective', 'detective', 'detective@roadsurfer.com', ['ROLE_USER']],
        ];
    }

    private function getStationData(): array
    {
        return [
            'Munich',
            'Paris',
            'Porto',
            'Madrid',
        ];
    }

    private function getCategoriesData(): array
    {
        return [
            'Campervans',
            'Portable Toilets',
            'Bed Sheets',
            'Sleeping Bags',
            'Camping Tables',
            'Chairs',
        ];
    }

    private function getProductsData(): array
    {
        return [
            // $productData = [$name, $shortDescription, $description, $price, $categories];
            [
                'VW California Beach Hire',
                'Beach Hostel Deluxe VW T6.1 California Beach',
                '150 hp diesel / DCT automation, Cooler box & small gas cooker, Manual pop-up roof, Three-seat rear bench, 2 front swivel seats, Stationary heating via air, Park-assist and rear camera, Awning Cruise and distance control, GPS',
                90.00,
                $this->getReference('category-Campervans'),
            ],
            [
                'VW T6 California Hire',
                'Surfer Suite VW T6.1 California Ocean',
                '150 hp / diesel / DCT automation, Integrated kitchen, Automatic pop-up roof, Outdoor shower (cold), 2 front swivel seats, Stationary heating via air, Park-assist and rear camera, Awning Cruise and distance control, GPS',
                105.00,
                $this->getReference('category-Campervans'),
            ],
            [
                'Bürstner Eliseo Hire',
                'Road House Eliseo Bürstner Eliseo',
                '140 hp diesel / 9-speed automatic, Bathroom with shower (warm/cold) & toilet, Living & sleeping are directly accessible, Spacious kitchen, Manual pop-up roof Air heating, Awning Park-assist, Tempomat, GPS',
                129.00,
                $this->getReference('category-Campervans'),
            ],
            [
                'TOI WATER UP',
                'TOI WATER UP Portable toilet',
                'Hand wash basin, WC & Urinal, Hand disinfection dispenser, LED light & ventilator',
                50.00,
                $this->getReference('category-Portable Toilets'),
            ],
            [
                'DIXI PLUS WASH',
                'DIXI PLUS WASH Portable toilet',
                'Compact hand wash basin, Soap dispenser and paper towels, High user-friendliness due to ergonomic design',
                65.00,
                $this->getReference('category-Portable Toilets'),
            ],
            [
                'Cotton Rich Sheet',
                '',
                '',
                5.00,
                $this->getReference('category-Bed Sheets'),
            ],
            [
                'Ruikasi multicoloured microfiber bed linen',
                'Ruikasi multicoloured microfiber bed linen',
                '',
                10.00,
                $this->getReference('category-Bed Sheets'),
            ],
            [
                'Temperature Connectable Breathable Sleeping Bag',
                'High Peak TR 300 Sleeping Bag',
                'Extra Wide, 3-4 Seasons, Temperature 0°C, Warm, Pack Bag, Connectable, For Camping, Festivals, Trekking, Breathable, Skin-friendly, Water-Repellent',
                8.00,
                $this->getReference('category-Sleeping Bags'),
            ],
            [
                'Bessport Mountaineering Ultra Light Ultra Compact Spray Bound',
                'Bessport Winter Sleeping Bag',
                '−9 and 0 ℃, Outdoor Mummy Sleeping Bag for Camping and Mountaineering with Ultra-Light and Ultra-Compact 100% Spray-Bound Cotton 400 g/m² Filling',
                12.00,
                $this->getReference('category-Sleeping Bags'),
            ],
            [
                'KingCamp 4 Folds Bamboo Camping Table',
                'KingCamp 4 Folds Bamboo Camping Table',
                'KingCamp 4 Folds Bamboo Camping Table, 3 Höhen 100 × 65 × 45 / 52 / 65 Cm, Folding Table Aluminium Frame 2–6 People',
                15.00,
                $this->getReference('category-Camping Tables'),
            ],
            [
                'Advanced Aluminium Foldable Lightweight Portable',
                'Ever Advanced Camping Table',
                'Ever Advanced Camping Table, Folding Table with Aluminium Table Top, Foldable, Lightweight, Portable, with Carry Bag, for 4 People, 70 x 70 cm',
                20.00,
                $this->getReference('category-Camping Tables'),
            ],
            [
                'Nexos Premium Folding Recliner Camping',
                'Nexos Set of 2 Premium Folding Chair Recliner Camping Chair',
                'Nexos Set of 2 Premium Folding Chair Recliner Camping Chair – for Garden Terrace Balcony – Folding Garden Chair Padded Aluminium – Black Grey',
                15.00,
                $this->getReference('category-Chairs'),
            ],
            [
                'SONGMICS Camping Folding Armrests',
                'SONGMICS Camping Folding Armrests',
                'SONGMICS Camping Chairs Set of 2 Folding Chairs Outdoor Chairs with Armrests and Cup Holder Sturdy Frame Holds up to 120 kg Green',
                10.00,
                $this->getReference('category-Chairs'),
            ],
        ];
    }

    private function getOrdersData(): array
    {
        return [
        ];
    }
}
