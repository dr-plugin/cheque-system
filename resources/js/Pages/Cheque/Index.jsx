import DashboardLayout from "@/Layouts/Dashboard/Layout"
import Pagination from "@/BaseComponents/Pagination"

import { formatAmount } from '@/functions/helper.js';
import { FiEdit } from "react-icons/fi";
import ModalMoveCheque from "./Components/ModalMoveCheque";

import { Link } from "@inertiajs/react";


function Index({ cheques, h1, clientTrans }) {

    return (
        <>
            <section>

                <table className="responsive-table">
                    <thead>
                        <tr>
                            <th>شماره صیادی</th>
                            <th>نزد</th>
                            <th>صادر کننده</th>
                            <th>بانک</th>
                            <th>تاریخ چک</th>
                            <th>مبلغ (ریال)</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        {cheques.data.map((item) => (

                            <tr key={item.id}>
                                <td>{item.sayadi_number}</td>
                                <td>{item.owner.name}</td>
                                <td>{item.exporter}</td>
                                <td>{item.bank_label}</td>
                                <td>{item.date_fa}</td>
                                <td>{formatAmount(item.price)}</td>
                                <td className="flex gap-2 justify-center">

                                    <ModalMoveCheque
                                        chequeId={item.id}
                                        price={item.price}
                                        due_date={item.due_date}
                                        date_fa={item.date_fa}
                                        payerId={item.owner.id}
                                        payerName={item.owner.name}
                                    />

                                    <Link href={`/cheque/${item.id}/edit`}>
                                        <FiEdit size={24} />
                                    </Link>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>

                <Pagination links={cheques.links} />
            </section>

            {clientTrans.length > 0 &&

                <section>
                    <h2>
                        تراکنشهای کاربر
                    </h2>
                    <table className="responsive-table">
                        <thead>
                            <tr>
                                <th>پرداخت کننده</th>
                                <th>دریافت کننده</th>
                                <th>شماره تراکنش</th>
                                <th>تاریخ ثبت</th>
                                <th>مبلغ (ریال)</th>
                                <th>توضیحات</th>
                            </tr>
                        </thead>
                        <tbody>
                            {clientTrans.map((item) => (
                                <tr key={item.id}>

                                    <td>
                                        {item.payer.name}
                                    </td>
                                    <td>
                                        {item.receiver.name}
                                    </td>
                                    <td>
                                        {item.transaction_id}
                                    </td>
                                    <td>
                                        {item.created_at}
                                    </td>
                                    <td>
                                        {formatAmount(item.price)}
                                    </td>
                                    <td>
                                        {item.comment}
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </section>
            }
        </>
    )
}

Index.layout = page => <DashboardLayout children={page} h1={page.props.h1} />

export default Index;