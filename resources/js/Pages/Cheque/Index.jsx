import DashboardLayout from "@/Layouts/Dashboard/Layout"
import Pagination from "@/BaseComponents/Pagination"

import { formatAmount } from '@/functions/helper.js';

import ModalMoveCheque from "./Components/ModalMoveCheque";


function Index({ cheques, h1 }) {

    if (cheques.data.length <= 0)
        return (<section>هیچ چکی یافت نشد</section>)
    else
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
                                    <td>
                                        <ModalMoveCheque
                                            chequeId={item.id}
                                            price={item.price}
                                            due_date={item.due_date}
                                            date_fa={item.date_fa}
                                            payerId={item.owner.id}
                                            payerName={item.owner.name}
                                        />
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>

                    <Pagination links={cheques.links} />
                </section>
            </>
        )
}

Index.layout = page => <DashboardLayout children={page} h1={page.props.h1} />

export default Index;