# Currency Exchange API Project

這是一個面試專案，使用Laravel實現簡單的貨幣兌換 API 服務。

## 如何運行本專案

請按照以下步驟運行本專案：

1. 構建 Docker image：

   ```bash
   docker build -t currency-exchange-image .
   ```
2. 運行 Docker 容器並將其端口映射到本地端口 8000：

   ```bash
   docker run -p 8000:8000 currency-exchange-image
   ```

## API 資訊

服務運行後，可以通過以下範例訪問 API：

## Request範例

發送 GET 請求至以下 URL 以獲取貨幣兌換結果：

### URL & query：

`GET http://localhost:8000/currencyExchange?source=USD&target=JPY&amount=1,000`

### 說明：

- **source**: 來源貨幣，例如 USD
- **target**: 目標貨幣，例如 JPY
- **amount**: 兌換金額，例如 1,000

## Response範例

成功時，API 將返回以下格式的 JSON 數據：

```json
{
    "success": true,
    "converted_amount": "111,801.00"
}
```
