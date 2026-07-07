import DashboardLayout from "@/Layouts/Dashboard/Layout"
import Pagination from "@/BaseComponents/Pagination"

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
                                <th>صادر کننده</th>
                                <th>شماره حساب</th>
                                <th>تصویر چک</th>
                                <th>وضعیت چک</th>
                                <th>بانک</th>
                                <th>تاریخ چک</th>
                                <th>مبلغ</th>
                                <th>نزد</th>
                            </tr>
                        </thead>
                        <tbody>
                            {cheques.data.map((item) => (
                                <tr key={item.id}>
                                    <td>{item.price}</td>
                                    <td>{item.sayadi_number}</td>
                                    <td>{item.exporter}</td>
                                    <td>{item.status}</td>
                                    <td>{item.bank}</td>
                                    <td>{item.owner.name}</td>
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