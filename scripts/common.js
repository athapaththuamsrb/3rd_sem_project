class XHRBuilder {
    constructor() {
        this.fields = {};
    }

    addField(fieldName, value) {
        this.fields[fieldName] = value;
    }

    build() {
        let encoded = Object.keys(this.fields).map((index) => {
            return encodeURIComponent(index) + '=' + encodeURIComponent(this.fields[index]);
        });
        return encoded.join("&");
    }
}

class TableBuilder {
    constructor(table = null) {
        if (table) {
            this.table = table;
        } else {
            this.table = document.createElement('table');
        }
    }

    addHeadingRow(...headings) {
        let tr = document.createElement('tr');
        headings.forEach(heading => {
            let th = document.createElement('th');
            th.innerText = heading;
            tr.appendChild(th);
        });
        this.table.appendChild(tr)
    }

    addRow(...data) {
        let tr = document.createElement('tr');
        data.forEach(text => {
            let td = document.createElement('td');
            td.innerText = text;
            tr.appendChild(td);
        });
        this.table.appendChild(tr)
    }

    build() {
        return this.table;
    }
}