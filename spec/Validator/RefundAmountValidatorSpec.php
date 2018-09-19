<?php

declare(strict_types=1);

namespace spec\Sylius\RefundPlugin\Validator;

use PhpSpec\ObjectBehavior;
use Sylius\RefundPlugin\Exception\InvalidRefundAmountException;
use Sylius\RefundPlugin\Model\OrderItemUnitRefund;
use Sylius\RefundPlugin\Model\RefundType;
use Sylius\RefundPlugin\Provider\RemainingTotalProviderInterface;
use Sylius\RefundPlugin\Validator\RefundAmountValidatorInterface;

final class RefundAmountValidatorSpec extends ObjectBehavior
{
    function let(RemainingTotalProviderInterface $remainingTotalProvider): void
    {
        $this->beConstructedWith($remainingTotalProvider);
    }

    function it_implements_refund_amount_validator_interface(): void
    {
        $this->shouldImplement(RefundAmountValidatorInterface::class);
    }

    function it_throws_exception_if_total_of_at_least_one_unit_is_below_zero(): void
    {
        $orderItemUnitRefund = new OrderItemUnitRefund(1, -10);

        $this
            ->shouldThrow(InvalidRefundAmountException::class)
            ->during('validateUnits', [[$orderItemUnitRefund], RefundType::orderItemUnit()])
        ;
    }
}
