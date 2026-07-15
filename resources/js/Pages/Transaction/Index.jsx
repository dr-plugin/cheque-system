import DashboardLayout from "@/Layouts/Dashboard/Layout"
import Pagination from "@/BaseComponents/Pagination"
import { Link } from "@inertiajs/react"
import { formatAmount } from '@/functions/helper.js';

function Index({ transactions }) {


    return (
        <>
            <section className="table-container">


                <table className="responsive-table">
                    <thead>
                        <tr>
                            <th>آیدی</th>
                            <th>پرداخت کننده</th>
                            <th>دریافت کننده</th>
                            <th>قیمت</th>
                            <th>توضیحات</th>
                            <th>تاریخ ایجاد</th>
                        </tr>
                    </thead>
                    <tbody>
                        {transactions.data.map((item) => (
                            <tr key={item.id}>
                                <td>{item.id}</td>
                                <td>{item.payer.name}</td>
                                <td>{item.receiver.name}</td>
                                <td>{formatAmount(item.price)}</td>
                                <td>{item.comment}</td>
                                <td>{item.created_at}</td>
                            </tr>
                        ))}
                    </tbody>
                </table>

                <Pagination links={transactions.links} />

            </section>
        </>
    )
}

Index.layout = page => <DashboardLayout children={page} h1='لیست تراکنش‌ها' />

export default Index;

// "id" => 1
// "price" => 18450185
// "transaction_id" => null
// "cheque_id" => 6
// "payer_id" => 3
// "receiver_id" => 2
// "comment" => ""
// "created_at" => "۱۴۰۵/۴/۲۱ ۱۶:۳۴"