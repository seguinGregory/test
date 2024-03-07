'''mermaid

sequenceDiagram
    participant User
    participant Application
    participant Provider
    participant Payment

    User ->> Application: PostBuyback
    Application ->> Payment: Mark as Created
    Payment ->> Payment: Change status to Created
    Payment ->> Application: Acknowledge
    Application ->> Payment: Mark as Awaiting
    Payment ->> Payment: Change status to Awaiting
    Payment ->> Application: Acknowledge
    Application ->> Provider: CreateBankAccount
    Provider -->> Application: BankId
    Application ->> Provider: CreateBankwirePayout
    Provider -->> Application: PayoutId
    Application ->> Payment: Mark as Initiated
    Payment ->> Payment: Change status to Initiated
    Payment ->> Application: Acknowledge
    Provider ->> Application: Webhook
    Application ->> Payment: Mark as Completed
    Payment ->> Payment: Change status to Completed
    Payment ->> Application: Acknowledge

'''