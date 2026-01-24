# VISUAL ERD - DARK AND BRIGHT DATABASE

## 📊 Entity Relationship Diagram (Text Format)

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                           DARK AND BRIGHT DATABASE                          │
│                              9 Tables Structure                             │
└─────────────────────────────────────────────────────────────────────────────┘


                            ┌────────────────────────┐
                            │  DESIGNPACKAGE (PK)    │
                            ├────────────────────────┤
                            │ • package_id (PK)      │
                            │ • name                 │
                            │ • description          │
                            │ • price                │
                            │ • category             │
                            │ • delivery_days        │
                            │ • status               │
                            └────────┬───────────────┘
                                     │ 1:N (package_id)
                                     │
                    ┌────────────────▼─────────────────┐
                    │         ORDER (PK)               │
                    ├────────────────────────────────┤
                    │ • order_id (PK)                │
                    │ • customer_id (FK→users)       │
                    │ • package_id (FK→designpackage)│
                    │ • admin_id (FK→users)          │
                    │ • brief_text                   │
                    │ • brief_file                   │
                    │ • created_at                   │
                    │ • due_date                     │
                    │ • status                       │
                    │ • updated_at                   │
                    └────┬──────┬──────┬───────┬──────┘
                         │      │      │       │
        ┌────────────────┘      │      │       │
        │                       │      │       │
        │        ┌──────────────┘      │       │
        │        │                     │       │
   1:N  │   1:N  │              1:N    │       │ 1:1
        │        │                     │       │
        │        │                     │       │
    ┌───▼─┐  ┌──▼─────┐    ┌─────────┐ │    ┌─▼──────────┐
    │PAYMENT            │  │CHATLOG  │ │    │ GUARANTEE  │
    │(PK)           │  │    │(PK)     │ │    │ CLAIM (PK) │
    │• payment_id   │  │    │• chat_id│ │    │ • claim_id │
    │• order_id (FK)│  │    │ ├─ order_id(FK) │├─ order_id(FK)
    │• amount       │  │    │ ├─ sender_id(FK→users)    │├─ customer_id(FK→users)
    │• method       │  │    │ └─ receiver_id(FK→users)  │├─ reason
    │• status       │  │    │ ├─ message      │├─ created_at
    │• proof        │  │    │ ├─ attachment   │├─ resolved_at
    │• timestamp    │  │    │ └─ timestamp    │└─ status
    └───────────────┘  │    └─────────────────┘  └────────────┘
                       │
                       │ 1:N
                       │
                  ┌────▼────────────┐
                  │REVISION (PK)    │
                  ├─────────────────┤
                  │ • revision_id   │
                  │ • order_id (FK) │
                  │ • revision_no   │
                  │ • request_note  │
                  │ • admin_id (FK→users)
                  │ • created_at    │
                  │ • resolved_at   │
                  └─────────────────┘


                  ┌──────────────────┐
                  │FINALFILE (PK)    │
                  ├──────────────────┤
                  │ • file_id        │
                  │ • order_id (FK)  │
                  │ • file_path      │
                  │ • file_type      │
                  │ • file_type_category
                  │ • uploaded_at    │
                  └──────────────────┘


        ┌────────────────────────────────────┐
        │         USERS (PK)                 │
        ├────────────────────────────────────┤
        │ • user_id (PK)                     │
        │ • name                             │
        │ • email (UNIQUE)                   │
        │ • password                         │
        │ • phone                            │
        │ • address                          │
        │ • role (customer | admin)          │
        │ • created_at                       │
        │ • updated_at                       │
        └────┬─────────────────┬─────────────┘
             │ 1:N (customer_id) 1:N (admin_id)
             │                   │
             └─────── ORDER ─────┘


        ┌────────────────────────────┐
        │    ADMINREPORT (PK)        │
        ├────────────────────────────┤
        │ • report_id (PK)           │
        │ • most_popular_package     │
        │ • total_orders             │
        │ • revenue                  │
        │ • completed_orders         │
        │ • refund_count             │
        │ • date_generated           │
        └────────────────────────────┘
```

---

## 📈 Relationship Matrix

| From Table      | To Table         | Relation | Foreign Key      | Type   |
|-----------------|------------------|----------|------------------|--------|
| USERS           | ORDER            | 1:N      | customer_id      | Has Many |
| USERS           | ORDER            | 1:N      | admin_id         | Has Many |
| USERS           | CHATLOG          | 1:N      | sender_id        | Has Many |
| USERS           | CHATLOG          | 1:N      | receiver_id      | Has Many |
| USERS           | REVISION         | 1:N      | admin_id         | Has Many |
| USERS           | GUARANTEECLAIM   | 1:N      | customer_id      | Has Many |
| DESIGNPACKAGE   | ORDER            | 1:N      | package_id       | Has Many |
| ORDER           | PAYMENT          | 1:N      | order_id         | Has Many |
| ORDER           | CHATLOG          | 1:N      | order_id         | Has Many |
| ORDER           | REVISION         | 1:N      | order_id         | Has Many |
| ORDER           | FINALFILE        | 1:N      | order_id         | Has Many |
| ORDER           | GUARANTEECLAIM   | 1:1      | order_id         | Has One |

---

## 🔄 Order Lifecycle

```
START
  │
  ├─► SUBMITTED (Order created)
  │      └─► IN_PROGRESS (Admin mulai kerjakan)
  │           ├─► REVISION (Customer request perubahan)
  │           │    └─► IN_PROGRESS (Admin revisi)
  │           │         └─► (loop ke REVISION jika perlu)
  │           │
  │           └─► COMPLETED (Desain selesai & delivered)
  │
  ├─► CANCELLED (Jika dibatalkan)
  │
END
```

---

## 💰 Payment Lifecycle

```
PENDING (Order baru, waiting for payment)
   │
   ├─► PAID (Pembayaran berhasil)
   │
   ├─► FAILED (Pembayaran gagal)
   │
   └─► REFUNDED (Pembayaran dikembalikan)
```

---

## 📋 Chat Communication Flow

```
Customer (user_id: 1)                    Admin (user_id: 2)
     │                                          │
     ├─────── SEND MESSAGE ──────────────────► │
     │        (chatlog entry created)          │
     │                                         │
     │  ◄───── SEND REPLY ────────────────────┤
     │        (admin sends response)           │
     │                                         │
     ├─────── SEND FEEDBACK ─────────────────► │
     │        (about revision request)         │
     │                                         │
     │  ◄───── SEND UPDATE ────────────────────┤
     │        (with attachment/design)         │
     │                                         │
     └─ ALL CHATS STORED IN CHATLOG TABLE ────┘
```

---

## 📊 Data Flow Example

### Scenario: Customer Order Logo Design

```
1. CUSTOMER REGISTERS
   ├─ INSERT → users (role='customer')
   └─ user_id: 1

2. CUSTOMER BROWSE PACKAGES
   ├─ SELECT → designpackage (WHERE status='active')
   └─ See: Logo Design (Rp 500.000, 7 days)

3. CUSTOMER CREATES ORDER
   ├─ INSERT → order (
   │   customer_id: 1,
   │   package_id: 1,
   │   brief_text: "...",
   │   status: "submitted",
   │   due_date: "2026-02-01"
   │ )
   └─ order_id: 1

4. CUSTOMER MAKES PAYMENT
   ├─ INSERT → payment (
   │   order_id: 1,
   │   amount: 500000,
   │   method: "bank_transfer",
   │   status: "pending"
   │ )
   └─ payment_id: 1

5. ADMIN ACCEPTS ORDER
   ├─ UPDATE → order (
   │   admin_id: 2,
   │   status: "in_progress"
   │ )

6. ADMIN & CUSTOMER CHAT
   ├─ INSERT → chatlog (sender_id: 1, receiver_id: 2, message: "...")
   ├─ INSERT → chatlog (sender_id: 2, receiver_id: 1, message: "...")
   └─ order_id: 1 (untuk semua chat)

7. ADMIN REQUESTS REVISION
   ├─ INSERT → revision (
   │   order_id: 1,
   │   revision_no: 1,
   │   request_note: "Tolong ubah warna...",
   │   admin_id: 2
   │ )
   └─ UPDATE → order (status: "revision")

8. ADMIN UPLOADS FINAL FILE
   ├─ INSERT → finalfile (
   │   order_id: 1,
   │   file_path: "storage/orders/1/logo.png",
   │   file_type: "png",
   │   file_type_category: "final"
   │ )

9. ORDER COMPLETED
   ├─ UPDATE → order (status: "completed")
   └─ UPDATE → payment (status: "paid")

10. ADMIN GENERATES REPORT
    ├─ INSERT → adminreport (
    │   date_generated: "2026-01-24",
    │   most_popular_package: "Logo Design",
    │   total_orders: 1,
    │   revenue: 500000,
    │   completed_orders: 1
    │ )
```

---

## 🎯 Key Features

### ✅ Complete Order Management
- From submission to completion
- Multi-step revision workflow
- Real-time communication

### ✅ Payment Integration
- Multiple payment methods
- Status tracking
- Payment proof storage

### ✅ File Management
- Source files (PSD, AI)
- Final deliverables
- Backup storage

### ✅ Communication System
- Order-specific chat
- File attachments
- Message history

### ✅ Quality Control
- Revision tracking
- Revision numbering
- Resolution timestamps

### ✅ Warranty System
- Customer claims
- Claim status workflow
- Resolution tracking

### ✅ Analytics
- Popular packages
- Revenue tracking
- Completion rates
- Refund monitoring

---

## 🔐 Integrity Constraints

### Foreign Key Constraints
```sql
-- order.customer_id → users.user_id (cascade delete)
-- order.package_id → designpackage.package_id (restrict delete)
-- order.admin_id → users.user_id (set null on delete)
-- payment.order_id → order.order_id (cascade delete)
-- chatlog.order_id → order.order_id (cascade delete)
-- chatlog.sender_id → users.user_id (cascade delete)
-- chatlog.receiver_id → users.user_id (cascade delete)
-- revision.order_id → order.order_id (cascade delete)
-- revision.admin_id → users.user_id (cascade delete)
-- finalfile.order_id → order.order_id (cascade delete)
-- guaranteeclaim.order_id → order.order_id (cascade delete)
-- guaranteeclaim.customer_id → users.user_id (cascade delete)
```

### Unique Constraints
```sql
-- users.email (UNIQUE)
```

### Not Null Constraints
```sql
-- All primary keys
-- All foreign keys (except nullable ones)
-- Required fields: name, email, password (users)
-- Required fields: order_id, customer_id, package_id (order)
```

---

## 📌 Indexes untuk Performance

```sql
-- Users
INDEX: email
INDEX: role

-- DesignPackage
INDEX: category
INDEX: status

-- Order
INDEX: customer_id
INDEX: admin_id
INDEX: package_id
INDEX: status
INDEX: due_date

-- Payment
INDEX: order_id
INDEX: status
INDEX: timestamp

-- ChatLog
INDEX: order_id
INDEX: sender_id
INDEX: receiver_id
INDEX: timestamp

-- Revision
INDEX: order_id
INDEX: admin_id
INDEX: revision_no

-- FinalFile
INDEX: order_id
INDEX: file_type
INDEX: uploaded_at

-- GuaranteeClaim
INDEX: order_id
INDEX: customer_id
INDEX: status

-- AdminReport
INDEX: date_generated
```

---

## 🎓 Database Statistics

| Metric | Value |
|--------|-------|
| Total Tables | 9 |
| Total Fields | 120+ |
| Primary Keys | 9 |
| Foreign Keys | 12 |
| Indexes | 25+ |
| Relationships | 1:N (8), 1:1 (1) |
| Normalization | 3NF |

---

**Database Design Complete! Ready for Development! 🚀**

Last Updated: 24 January 2026
