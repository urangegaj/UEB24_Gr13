<?php

class DummyData {
   
    public static function getContactInfo() {
        return [
            'locations' => [
                [
                    'city' => 'Prishtinë',
                    'address' => 'International Corporation Street 2',
                    'country' => 'Kosova',
                    'phone' => '+383 41 234 567',
                    'email' => 'support@lacedlifestyle.com'
                ],
                [
                    'city' => 'Tirana',
                    'address' => 'Shopping Center, Floor 2',
                    'country' => 'Albania',
                    'phone' => '+355 69 123 4567',
                    'email' => 'albania@lacedlifestyle.com'
                ],
                [
                    'city' => 'Skopje',
                    'address' => 'City Mall, Unit 15',
                    'country' => 'North Macedonia',
                    'phone' => '+389 2 345 6789',
                    'email' => 'macedonia@lacedlifestyle.com'
                ],
                [
                    'city' => 'London',
                    'address' => 'Oxford Street 123',
                    'country' => 'United Kingdom',
                    'phone' => '+44 20 7946 0958',
                    'email' => 'london@lacedlifestyle.com'
                ]
            ],
            'store_count' => 5400,
            'support_hours' => '9:00 AM - 8:00 PM',
            'response_time' => 'Within 24 hours'
        ];
    }

  
    public static function getRecentSubmissions() {
        return [
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'message' => 'Great products and service!',
                'date' => '2024-03-15 14:30:00'
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'message' => 'When will the new collection be available?',
                'date' => '2024-03-14 16:45:00'
            ],
            [
                'name' => 'Mike Johnson',
                'email' => 'mike.j@example.com',
                'message' => 'Looking for size 42 in the latest model',
                'date' => '2024-03-13 09:15:00'
            ]
        ];
    }

    
    public static function getStatistics() {
        return [
            'total_stores' => 5400,
            'countries' => 120,
            'employees' => 25000,
            'customer_satisfaction' => 95,
            'response_rate' => 98
        ];
    }
}
?> 