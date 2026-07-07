import { TfiWallet } from "react-icons/tfi";
import { FiPlusCircle } from "react-icons/fi";
import { usePage, Link } from "@inertiajs/react";
import DarkSwitch from "../Components/DarkSwitch";
import { formatAmount } from "@/helper.js";
import Logo from "../Components/Logo";


export default function DashboardHeader({ h1 }) {

    const { auth } = usePage().props;

    let walletBalance = auth.user !== null ? auth.user.wallet_balance : 0;

    return (
        <header className="app-content-header">
            <Logo />
            <div className="user-bag flex">

                <TfiWallet size={20} />

                <div className="ub-amount flex">
                    <b className="amount">
                        {formatAmount(walletBalance)}
                    </b>
                    <p className="curency">
                        تومان
                    </p>
                </div>

                <Link href='/dashboard/transactions'>
                    <FiPlusCircle size={20} />
                </Link>

            </div>

            <div className="vertical-hr"></div>

            <DarkSwitch />

        </header>
    )
}