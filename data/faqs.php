<?php
require_once __DIR__ . '/../classes/FAQ.php';

$faqData = [
    'general' => [
        new FAQ(
            'What is Falcones Capital?',
            'Falcones Capital is a proprietary trading firm that provides funding to skilled traders. Pass our evaluation challenge, and trade with our capital while keeping up to 100% of your profits.',
            'general'
        ),
        new FAQ(
            'How does the evaluation work?',
            'Our evaluation is a one-step process. You need to achieve an 8% profit target while respecting the 5% daily and 10% maximum drawdown limits. There is no time limit to complete the challenge.',
            'general'
        ),
        new FAQ(
            'Is there a time limit for the challenge?',
            'No, there is no time limit. Take as long as you need to reach the profit target. We believe in quality trading, not rushed decisions.',
            'general'
        ),
        new FAQ(
            'What platforms can I trade on?',
            'We offer MetaTrader 5, cTrader, and Match-Trader. You can choose your preferred platform when purchasing your challenge.',
            'general'
        ),
    ],
    'trading' => [
        new FAQ(
            'What trading strategies are allowed?',
            'Most strategies are allowed including scalping, day trading, swing trading, news trading, and using Expert Advisors (EAs). However, strategies like martingale without stop loss, arbitrage, and latency exploitation are prohibited.',
            'trading'
        ),
        new FAQ(
            'Can I hold trades overnight and over weekends?',
            'Yes, you can hold positions overnight and over weekends. There are no restrictions on how long you keep your trades open.',
            'trading'
        ),
        new FAQ(
            'What is the profit target?',
            'The profit target is 8% of your initial account balance. Once you achieve this during the evaluation, you become a funded trader.',
            'trading'
        ),
        new FAQ(
            'What are the drawdown rules?',
            'Daily drawdown is 5% of your starting balance for that day. Maximum drawdown is 10% of your initial account balance. These are designed to encourage responsible risk management.',
            'trading'
        ),
    ],
    'payouts' => [
        new FAQ(
            'How often can I request a payout?',
            'You can request payouts every 14 days (bi-weekly). Our processing time is typically 24-48 hours.',
            'payouts'
        ),
        new FAQ(
            'What is the profit split?',
            'Profit splits range from 60% to 100% depending on your account size and scaling level. You can increase your split by consistently trading profitably and scaling your account.',
            'payouts'
        ),
        new FAQ(
            'What payment methods are available?',
            'We support bank transfers, cryptocurrency (Bitcoin, USDT), and other payment methods depending on your region.',
            'payouts'
        ),
        new FAQ(
            'Is there a minimum withdrawal amount?',
            'The minimum withdrawal amount is $100. There is no maximum limit on how much you can withdraw.',
            'payouts'
        ),
    ],
    'account' => [
        new FAQ(
            'How do I get started?',
            'Simply choose your preferred account size on our Challenges page, complete the purchase, and you will receive your account credentials instantly via email.',
            'account'
        ),
        new FAQ(
            'What happens if I fail the challenge?',
            'If you violate the drawdown rules, the challenge ends. You can purchase a new challenge at any time to try again. We also offer discounts for returning traders.',
            'account'
        ),
        new FAQ(
            'Can I have multiple accounts?',
            'Yes, you can have multiple challenge accounts simultaneously. However, you cannot use the same strategy across accounts to hedge or guarantee profits.',
            'account'
        ),
        new FAQ(
            'How does the scaling plan work?',
            'Consistent traders can scale their accounts up to $300,000 in capital. As you scale, your profit split also increases, potentially reaching 100%.',
            'account'
        ),
    ],
];
