# Deploy no Google Cloud Run

## 🚀 Configurações Aplicadas

As seguintes alterações foram feitas para compatibilidade com Cloud Run:

### 1. **Dockerfile Otimizado**
- ✅ Container escuta na porta definida pela variável `PORT` (padrão: 8080)
- ✅ Nginx configurado com template dinâmico
- ✅ Entrypoint script que substitui a porta em runtime
- ✅ Permissões corretas para `www-data`
- ✅ Build otimizado sem dependências de desenvolvimento

### 2. **Nginx Configuração**
- ✅ `nginx.conf` principal criado
- ✅ `default.conf` com variável `${PORT}` para substituição dinâmica
- ✅ Gzip habilitado para compressão
- ✅ Client max body size: 20MB

### 3. **Entrypoint Script**
- ✅ Substitui porta dinamicamente via `envsubst`
- ✅ Cria arquivo SQLite se necessário
- ✅ Gera APP_KEY automaticamente
- ✅ Otimiza caches para produção
- ✅ Ajusta permissões automaticamente

### 4. **Arquivos de Configuração**
- ✅ `.gcloudignore` - Ignora arquivos desnecessários no build
- ✅ `.dockerignore` - Otimiza imagem Docker

---

## 📋 Pré-requisitos

- Google Cloud SDK instalado e configurado
- Projeto GCP criado
- Billing ativado no projeto
- Cloud Run API habilitada

---

## 🔧 Comandos de Deploy

### 1. **Deploy Manual via gcloud**

```bash
# Deploy direto do repositório GitHub
gcloud run deploy codevilla-qualitativas \
  --source=https://github.com/DevAngeloOliveira/codevilla-qualitativas \
  --region=us-central1 \
  --platform=managed \
  --allow-unauthenticated \
  --set-env-vars="APP_ENV=production,APP_DEBUG=false,DB_CONNECTION=pgsql" \
  --max-instances=10 \
  --memory=1Gi \
  --cpu=1 \
  --timeout=300s
```

### 2. **Deploy com Build Local**

```bash
# Fazer build da imagem localmente
gcloud builds submit --tag gcr.io/SEU_PROJECT_ID/codevilla-qualitativas

# Deploy da imagem
gcloud run deploy codevilla-qualitativas \
  --image gcr.io/SEU_PROJECT_ID/codevilla-qualitativas \
  --region=us-central1 \
  --platform=managed \
  --allow-unauthenticated
```

### 3. **Deploy via Cloud Build (CI/CD)**

Crie um arquivo `cloudbuild.yaml` na raiz:

```yaml
steps:
  # Build da imagem Docker
  - name: 'gcr.io/cloud-builders/docker'
    args: ['build', '-t', 'gcr.io/$PROJECT_ID/codevilla-qualitativas', '.']
  
  # Push da imagem para Container Registry
  - name: 'gcr.io/cloud-builders/docker'
    args: ['push', 'gcr.io/$PROJECT_ID/codevilla-qualitativas']
  
  # Deploy no Cloud Run
  - name: 'gcr.io/google.com/cloudsdktool/cloud-sdk'
    entrypoint: gcloud
    args:
      - 'run'
      - 'deploy'
      - 'codevilla-qualitativas'
      - '--image=gcr.io/$PROJECT_ID/codevilla-qualitativas'
      - '--region=us-central1'
      - '--platform=managed'
      - '--allow-unauthenticated'

images:
  - 'gcr.io/$PROJECT_ID/codevilla-qualitativas'
```

Executar:
```bash
gcloud builds submit --config cloudbuild.yaml
```

---

## 🔐 Variáveis de Ambiente Necessárias

Configure as variáveis de ambiente no Cloud Run:

```bash
gcloud run services update codevilla-qualitativas \
  --region=us-central1 \
  --set-env-vars="
APP_NAME='Codevilla Qualitativas',
APP_ENV=production,
APP_DEBUG=false,
APP_URL=https://sua-url.run.app,
DB_CONNECTION=pgsql,
DB_HOST=db.tnbvzksyqrgxntpptbtt.supabase.co,
DB_PORT=5432,
DB_DATABASE=postgres,
DB_USERNAME=postgres,
DB_PASSWORD=postgres,
LOG_CHANNEL=stderr,
SESSION_DRIVER=cookie,
CACHE_DRIVER=file,
QUEUE_CONNECTION=sync
"
```

### Para usar MySQL (Cloud SQL):

```bash
# Criar instância Cloud SQL
gcloud sql instances create codevilla-db \
  --database-version=MYSQL_8_0 \
  --tier=db-f1-micro \
  --region=us-central1

# Criar banco de dados
gcloud sql databases create codevilla_qualitativas \
  --instance=codevilla-db

# Criar usuário
gcloud sql users create codevilla \
  --instance=codevilla-db \
  --password=SUA_SENHA_SEGURA

# Deploy com conexão Cloud SQL
gcloud run deploy codevilla-qualitativas \
  --region=us-central1 \
  --add-cloudsql-instances=SEU_PROJECT_ID:us-central1:codevilla-db \
  --set-env-vars="
DB_CONNECTION=pgsql,
DB_HOST=/cloudsql/SEU_PROJECT_ID:us-central1:codevilla-db,
DB_PORT=3306,
DB_DATABASE=codevilla_qualitativas,
DB_USERNAME=codevilla,
DB_PASSWORD=SUA_SENHA_SEGURA
"
```

---

## 🔒 Configurar Secrets (Recomendado)

Para senhas e chaves sensíveis, use Secret Manager:

```bash
# Criar secret para APP_KEY
echo -n "base64:SUA_CHAVE_GERADA" | gcloud secrets create app-key --data-file=-

# Criar secret para DB_PASSWORD
echo -n "SUA_SENHA" | gcloud secrets create db-password --data-file=-

# Dar permissão para Cloud Run acessar secrets
gcloud secrets add-iam-policy-binding app-key \
  --member=serviceAccount:SERVICE_ACCOUNT_EMAIL \
  --role=roles/secretmanager.secretAccessor

# Deploy com secrets
gcloud run deploy codevilla-qualitativas \
  --region=us-central1 \
  --set-secrets=APP_KEY=app-key:latest,DB_PASSWORD=db-password:latest
```

---

## 📊 Configurações de Performance

### Otimizar para Produção:

```bash
gcloud run services update codevilla-qualitativas \
  --region=us-central1 \
  --min-instances=1 \
  --max-instances=10 \
  --cpu=2 \
  --memory=2Gi \
  --timeout=300s \
  --concurrency=80
```

### Habilitar HTTP/2:
```bash
gcloud run services update codevilla-qualitativas \
  --region=us-central1 \
  --use-http2
```

---

## 🌐 Configurar Domínio Customizado

```bash
# Mapear domínio
gcloud run domain-mappings create \
  --service=codevilla-qualitativas \
  --domain=codevilla.seudominio.com \
  --region=us-central1
```

---

## 📝 Logs e Monitoramento

```bash
# Ver logs em tempo real
gcloud run services logs tail codevilla-qualitativas --region=us-central1

# Ver últimas 100 linhas
gcloud run services logs read codevilla-qualitativas \
  --region=us-central1 \
  --limit=100
```

---

## 🐛 Troubleshooting

### Erro: Container failed to start

1. **Verificar logs**:
   ```bash
   gcloud run services logs tail codevilla-qualitativas --region=us-central1
   ```

2. **Testar localmente**:
   ```bash
   docker build -t codevilla-test .
   docker run -p 8080:8080 -e PORT=8080 codevilla-test
   ```

3. **Verificar porta**:
   - Container DEVE escutar na porta definida por `$PORT`
   - Nginx configurado com `${PORT}` template

### Erro: APP_KEY not set

```bash
# Gerar chave localmente
php artisan key:generate --show

# Configurar no Cloud Run
gcloud run services update codevilla-qualitativas \
  --set-env-vars="APP_KEY=base64:SUA_CHAVE_GERADA"
```

### Erro: Permission denied (storage)

O entrypoint script já ajusta permissões, mas se necessário:

```bash
# Adicionar ao Dockerfile
RUN chown -R www-data:www-data /var/www/html/storage
```

---

## ✅ Checklist de Deploy

- [ ] APP_KEY configurada
- [ ] DB_CONNECTION configurada (pgsql)
- [ ] APP_URL configurada com URL do Cloud Run
- [ ] LOG_CHANNEL=stderr (para logs no Cloud Logging)
- [ ] APP_DEBUG=false em produção
- [ ] Migrations executadas (se necessário)
- [ ] Storage permissions corretas
- [ ] CORS configurado (se necessário)
- [ ] Domínio customizado mapeado (opcional)
- [ ] Monitoramento configurado

---

## 💰 Estimativa de Custos

Cloud Run cobra por:
- **CPU**: Tempo de processamento
- **Memória**: Uso de RAM
- **Requests**: Número de requisições
- **Egress**: Tráfego de saída

**Tier Gratuito (Free Tier)**:
- 2 milhões de requests/mês
- 360.000 GB-seconds de memória/mês
- 180.000 vCPU-seconds/mês

Para tráfego baixo-médio, o custo é **praticamente zero**!

---

## 📚 Documentação Oficial

- [Cloud Run Docs](https://cloud.google.com/run/docs)
- [Cloud SQL for PostgreSQL](https://cloud.google.com/sql/docs/postgres)
- [Secret Manager](https://cloud.google.com/secret-manager/docs)

---

**Última atualização**: 09/01/2026
